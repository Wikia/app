#include <stdio.h>
#include <vector>
#include <string>

#define MAX_DIFF_LINE 10000

enum optype { ins, rep, del, copy };

// a small class to accomodate word-level diffs; basically, a body and an
// optional suffix (the latter consisting of a single whitespace), where
// only the bodies are compared on operator==.
class Word {
public:
	std::string body;
	std::string whole;
	
	Word(std::string body, std::string suffix) : body(body), whole(body + suffix) {}
	bool operator== (const Word &w) const {
		return (body == w.body);
	}
};

// operations for the diff, as returned by do_diff
template<class T>
struct diff_op
{
	unsigned char op;
	const T *from, *to;
	unsigned from_ind, to_ind;

	diff_op<T> () {}
};

template<class T>
std::vector<diff_op<T> > do_diff(const std::vector<T> &text1, const std::vector<T> &text2);

template<class T>
void backtrack_diff(const std::vector<T> &text1, const std::vector<T> &text2, unsigned char *start, unsigned stride, unsigned i, unsigned j, std::vector<diff_op<T> > &ret);

void print_diff(std::vector<std::string> &text1, std::vector<std::string> &text2, unsigned num_lines_context, std::string &ret);
void print_worddiff(const char * const text1, const char * const text2, std::string &ret);
void print_worddiff_side(std::vector<diff_op<Word> > &worddiff, bool added, std::string &ret);
void split_tokens(const char *text, std::vector<Word> &tokens);

void print_diff(std::vector<std::string> &text1, std::vector<std::string> &text2, unsigned num_lines_context, std::string &ret)
{
	// first do line-level diff
	std::vector<diff_op<std::string> > linediff = do_diff(text1, text2);
	int ctx = 0;

	for (unsigned i = 0; i < linediff.size(); ++i) {
		switch (linediff[i].op) {
		case ins:
			// inserted line
			ret += "<tr>"
				"<td colspan=\"2\">&nbsp;</td>"
			        "<td>+</td>"
			        "<td class=\"diff-addedline\">" + *linediff[i].to + "</td></tr>";
			break;
		case del:
			// deleted text
			ret += "<tr>"
				"<td>-</td>"
				"<td class=\"diff-deletedline\">" + *linediff[i].from + "</td>"
				"<td colspan=\"2\">&nbsp;</td>"
				"</tr>";
			break;
		case copy:
			// copy/context
			if (ctx == 0) {
				// peek to see if next NUM_LINES_CONTEXT lines are also context -- if so, don't print this
				bool context_future = true;
				for (unsigned j = 0; j < num_lines_context; ++j) {
					if (i + j + 1 < linediff.size() && linediff[i + j + 1].op != copy) {
						context_future = false;
						break;
					}
				}
				if (context_future)
					break;

				char buf[256]; // should be plenty
				sprintf(buf, "<tr><td colspan=\"2\" align=\"left\"><strong>Line %u:</strong></td>"
					"<td colspan=\"2\" align=\"left\"><strong>Line %u:</strong></td></tr>",
					linediff[i].from_ind + 1, linediff[i].to_ind + 1);
				ret += buf;

				// reset ctx so we won't print this heading over and over again
				ctx = num_lines_context;
			}
			
			ret += "<tr><td> </td><td class=\"diff-context\">" + *linediff[i].from + "</td>"
				"<td> </td><td class=\"diff-context\">" + *linediff[i].to + "</td></tr>";
			break;
		case rep:
			// replace, ie. we do a word diff between the two lines
			print_worddiff(linediff[i].from->c_str(), linediff[i].to->c_str(), ret);
			break;
		}

		if (linediff[i].op == copy) {
			if (ctx > 0)
				--ctx;
		} else {
			ctx = num_lines_context;
		}
	}
}

void print_worddiff(const char * const text1, const char * const text2, std::string &ret)
{
	std::vector<Word> text1_words, text2_words;

	split_tokens(text1, text1_words);
	split_tokens(text2, text2_words);
	std::vector<diff_op<Word> > worddiff = do_diff(text1_words, text2_words);
	
	// print twice; first for left side, then for right side
	ret += "<tr>"
		"<td>-</td>"
		"<td class=\"diff-deletedline\">";
	print_worddiff_side(worddiff, false, ret);
	ret += "</td>"
		"<td>+</td>"
		"<td class=\"diff-addedline\">";
	print_worddiff_side(worddiff, true, ret);
	ret += "</td>"
		"</tr>";
}

void print_worddiff_side(std::vector<diff_op<Word> > &worddiff, bool added, std::string &ret)
{
	bool in_changetext = false;
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		if (added && worddiff[i].op == del)
			continue;
		else if (!added && worddiff[i].op == ins)
			continue;
		if (in_changetext && worddiff[i].op == copy)
			ret += "</span>";
		else if (!in_changetext && worddiff[i].op != copy)
			ret += "<span class=\"diffchange\">";

		if (added)
			ret += worddiff[i].to->whole;
		else
			ret += worddiff[i].from->whole;

		in_changetext = (worddiff[i].op != copy);
	}
	if (in_changetext)
		ret += "</span>";
}

inline bool my_istext(unsigned char ch)
{
	return (ch >= '0' && ch <= '9') ||
	   (ch == '_') ||
	   (ch >= 'A' && ch <= 'Z') ||
	   (ch >= 'a' && ch <= 'z') ||
	   (ch >= 0x80 /* && ch <= 0xFF */);
}

// split a string into multiple tokens, just like the monster regex in DifferenceEngine.php
void split_tokens(const char *text, std::vector<Word> &tokens)
{
	if (strlen(text) > MAX_DIFF_LINE) {
		std::string everything(text);
		tokens.push_back(Word(everything, everything));
		return;
	}
	
	const char *ptr = text;

	while (*ptr) {
		std::string body, suffix;
		char ch = *ptr;
		
		// first group has three different opportunities:
		if (ch == ' ' || ch == '\t') {
			// one or more whitespace characters (but not \n)
			while (*ptr == ' ' || *ptr == '\t') { 
				body.push_back(*ptr++);
			}
		} else if (my_istext(ch)) {
			// one or more text characters
			while (my_istext(*ptr)) {
				body.push_back(*ptr++);
			}
		} else {
			// one character, no matter what it is
			body.push_back(*ptr++);
		}

		// second group: if the first character was not \n,
		// any whitespace character that is not \n (if any)
		if (ch != '\n') {
			if (*ptr == ' ' || *ptr == '\t') {
				suffix.push_back(*ptr++);
			}
		}

		tokens.push_back(Word(body, suffix));
	 }
}

template<class T>
std::vector<diff_op<T> > do_diff(const std::vector<T> &text1, const std::vector<T> &text2)
{
	unsigned *prevline = new unsigned[text2.size() + 1];
	unsigned *thisline = new unsigned[text2.size() + 1];
	
	unsigned char *eops = new unsigned char[(text1.size() + 1) * (text2.size() + 1)];
	unsigned char *prevline_eops = eops;
	unsigned char *thisline_eops = eops + (text2.size() + 1);

	// fill the first line
	for (unsigned j = 0; j <= text2.size(); ++j) {
		prevline[j] = j;
		prevline_eops[j] = ins;
	}
	
	for (unsigned i = 1; i <= text1.size(); ++i) {
		// only applicable operation at the start here is delete
		thisline[0] = prevline[0] + 1;
		thisline_eops[0] = del;

		for (unsigned j = 1; j <= text2.size(); ++j) {
			unsigned delcost = prevline[j] + 10;
			unsigned inscost = thisline[j - 1] + 10;

			// Replace costs 11, but replacement of a token
			// with itself (copy) is of course free. Note that
			// replace is slightly more expensive than add/delete
			// so that two replacements are more expensive than
			// an add+delete (but one replacement is of course
			// cheaper than an add+delete). This should make
			// the code a bit more forgiving with regard to text
			// blocks moving around.
			bool same = (text2[j - 1] == text1[i - 1]);
			unsigned repcost = prevline[j - 1];
			if (!same)
				repcost += 11;

			// determine what operation (ins, del, rep) is optimal
			if (repcost <= inscost && repcost <= delcost) {
				thisline[j] = repcost;
				thisline_eops[j] = same ? copy : rep;
			} else if (inscost <= repcost && inscost <= delcost) {
				thisline[j] = inscost;
				thisline_eops[j] = ins;
			} else {
				thisline[j] = delcost;
				thisline_eops[j] = del;
			}
		}

		std::swap(prevline, thisline);
		prevline_eops = thisline_eops;
		thisline_eops += (text2.size() + 1);
	}

	// now go back through the edit-op array to find the optimal diff, and store
	// those in an array
	std::vector<diff_op<T> > ret;
	ret.reserve(text1.size() + text2.size() + 1); // make sure we won't have to realloc
	backtrack_diff(text1, text2, eops, text2.size() + 1, text1.size(), text2.size(), ret);

	delete[] prevline;
	delete[] thisline;
	delete[] eops;

	return ret;
}

template<class T>
void backtrack_diff(const std::vector<T> &text1, const std::vector<T> &text2, unsigned char *eops, unsigned stride, unsigned i, unsigned j, std::vector<diff_op<T> > &ret)
{
	if (i == 0 && j == 0)
		return;

	// note that the from/to indices and pointers might very well be
	// invalid if they do not make sense for the given operation!
	diff_op<T> op;
	op.op = eops[i * stride + j];
	op.from_ind = i - 1;
	op.to_ind = j - 1;
	op.from = &text1[op.from_ind];
	op.to = &text2[op.to_ind];
	
	switch (op.op) {
	case ins:
		// inserted text
		backtrack_diff(text1, text2, eops, stride, i, j - 1, ret);
		break;
	case del:
		// deleted text
		backtrack_diff(text1, text2, eops, stride, i - 1, j, ret);
		break;
	case rep:
	case copy:
		backtrack_diff(text1, text2, eops, stride, i - 1, j - 1, ret);
		break;
	}

	ret.push_back(op);
}

void line_explode(const char *text, std::vector<std::string> &lines)
{
	const char *ptr = text;
	while (*ptr) {
		const char *ptr2 = strchr(ptr, '\n');
		if (ptr2 == NULL)
			ptr2 = ptr + strlen(ptr);
			
		lines.push_back(std::string(ptr, ptr2));

		ptr = ptr2;
		if (*ptr)
			++ptr;
	}
}

// Finally, the entry point for the PHP code.
const char *wikidiff_do_diff(const char *text1, const char *text2, int num_lines_context)
{
	try {
		std::vector<std::string> lines1;
		std::vector<std::string> lines2;
		std::string ret;
		
		// constant reallocation is bad for performance (note: we might want to reduce this
		// later, it might be too much)
		ret.reserve(strlen(text1) + strlen(text2) + 10000);
		
		line_explode(text1, lines1);
		line_explode(text2, lines2);
		print_diff(lines1, lines2, num_lines_context, ret);
		
		return strdup(ret.c_str());
	} catch (std::bad_alloc &e) {
		return strdup("Out of memory in diff.");
	} catch (...) {
		return strdup("Unknown exception in diff.");
	}
}
