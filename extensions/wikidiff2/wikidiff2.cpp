/**
 * Diff formatter, based on code by Steinar H. Gunderson, converted to work with the 
 * Dairiki diff engine by Tim Starling
 * 
 * GPL.
 */

#include <stdio.h>

#include "wikidiff2.h"

void print_diff(std::vector<std::string> &text1, std::vector<std::string> &text2, int num_lines_context, std::string &ret)
{
	// first do line-level diff
	Diff<std::string> linediff(text1, text2);
	
	int ctx = 0;
	int from_ind = 1, to_ind = 1;
	int num_ops = linediff.size();

	// Should a line number be printed before the next context line?
	// Set to true initially so we get a line number on line 1
	bool showLineNumber = true; 

	for (int i = 0; i < num_ops; ++i) {
		int n, j, n1, n2;
		// Line 1 changed, show heading with no leading context
		if (linediff[i].op != DiffOp<std::string>::copy && i == 0) {
			ret += 
				"<tr>\n"
				"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE 1--></td>\n"
				"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE 1--></td>\n"
				"</tr>\n";
		}
			
		switch (linediff[i].op) {
			case DiffOp<std::string>::add:
				// inserted lines
				n = linediff[i].to.size();
				for (j=0; j<n; j++) {
					print_add(*linediff[i].to[j], ret);
				}
				to_ind += n;
				break;
			case DiffOp<std::string>::del:
				// deleted lines
				n = linediff[i].from.size();
				for (j=0; j<n; j++) {
					print_del(*linediff[i].from[j], ret);
				}
				from_ind += n;
				break;
			case DiffOp<std::string>::copy:
				// copy/context
				n = linediff[i].from.size();
				for (j=0; j<n; j++) {
					if ((i != 0 && j < num_lines_context) /*trailing*/
							|| (i != num_ops - 1 && j >= n - num_lines_context)) /*leading*/ {
						if (showLineNumber) {
							// Print Line: heading
							char buf[256]; // should be plenty
							sprintf(buf, 
								"<tr>\n"
								"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE %u--></td>\n"
								"  <td colspan=\"2\" class=\"diff-lineno\"><!--LINE %u--></td>\n"
								"</tr>\n",
								from_ind, to_ind);
							ret += buf;
							showLineNumber = false;
						}
						// Print context
						ret += 
							"<tr>\n"
							"  <td class=\"diff-marker\"> </td>\n"
							"  <td class=\"diff-context\">";
						print_div_htmlspecialchars(*linediff[i].from[j], ret);
						ret += 
							"</td>\n"
							"  <td class=\"diff-marker\"> </td>\n"
							"  <td class=\"diff-context\">";
						print_div_htmlspecialchars(*linediff[i].from[j], ret);
						ret += "</td>\n</tr>\n";
					} else {
						showLineNumber = true;
					}
					from_ind++;
					to_ind++;
				}
				break;
			case DiffOp<std::string>::change:
				// replace, ie. we do a word diff between the two sets of lines
				n1 = linediff[i].from.size();
				n2 = linediff[i].to.size();
				n = std::min(n1, n2);
				for (j=0; j<n; j++) {
					print_worddiff(*linediff[i].from[j], *linediff[i].to[j], ret);
				}
				from_ind += n;
				to_ind += n;
				if (n1 > n2) {
					for (j=n2; j<n1; j++) {
						print_del(*linediff[i].from[j], ret);
					}
				} else {
					for (j=n1; j<n2; j++) {
						print_add(*linediff[i].to[j], ret);
					}
				}
				break;
		}
		// Not first line anymore, don't show line number by default
		showLineNumber = false;
	}
}

void print_add(const std::string & line, std::string & ret) 
{
	ret += "<tr>\n"
		"  <td colspan=\"2\">&nbsp;</td>\n"
		"  <td class=\"diff-marker\">+</td>\n"
		"  <td class=\"diff-addedline\">";
	print_div_htmlspecialchars(line, ret);
	ret += "</td>\n</tr>\n";
}

void print_del(const std::string & line, std::string & ret)
{
	ret += "<tr>\n"
		"  <td class=\"diff-marker\">-</td>\n"
		"  <td class=\"diff-deletedline\">";
	print_div_htmlspecialchars(line, ret);
	ret += "</td>\n"
		"  <td colspan=\"2\">&nbsp;</td>\n"
		"</tr>\n";
}

void print_worddiff(const std::string & text1, const std::string & text2, std::string &ret)
{
	std::vector<Word> text1_words, text2_words;

	split_tokens(text1, text1_words);
	split_tokens(text2, text2_words);
	Diff<Word> worddiff(text1_words, text2_words);
	
	//debug_print_worddiff(worddiff, ret);
	
	// print twice; first for left side, then for right side
	ret += "<tr>\n"
		"  <td class=\"diff-marker\">-</td>\n"
		"  <td class=\"diff-deletedline\"><div>\n";
	print_worddiff_side(worddiff, false, ret);
	ret += "\n  </div></td>\n"
		"  <td class=\"diff-marker\">+</td>\n"
		"  <td class=\"diff-addedline\"><div>\n";
	print_worddiff_side(worddiff, true, ret);
	ret += "\n  </div></td>\n"
		"</tr>\n";
}

void debug_print_worddiff(Diff<Word> &worddiff, std::string &ret)
{
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];	
		switch (op.op) {
			case DiffOp<Word>::copy:
				ret += "Copy\n";
				break;
			case DiffOp<Word>::del:
				ret += "Delete\n";
				break;
			case DiffOp<Word>::add:
				ret += "Add\n";
				break;
			case DiffOp<Word>::change:
				ret += "Change\n";
				break;
		}
		ret += "From: ";
		bool first = true;
		for (int j=0; j<op.from.size(); j++) {
			if (first) {
				first = false;
			} else {
				ret += ", ";
			}
			ret += "(";
			ret += op.from[j]->whole() + ")";
		}
		ret += "\n";
		ret += "To: ";
		first = true;
		for (int j=0; j<op.to.size(); j++) {
			if (first) {
				first = false;
			} else {
				ret += ", ";
			}
			ret += "(";
			ret += op.to[j]->whole() + ")";
		}
		ret += "\n\n";
	}
}

void print_worddiff_side(Diff<Word> &worddiff, bool added, std::string &ret)
{
	std::string word;
	for (unsigned i = 0; i < worddiff.size(); ++i) {
		DiffOp<Word> & op = worddiff[i];
		int n, j;
		if (op.op == DiffOp<Word>::copy) {
			n = op.from.size();
			if (added) {
				for (j=0; j<n; j++) {
					op.to[j]->get_whole(word);
					print_htmlspecialchars(word, ret);
				}
			} else {
				for (j=0; j<n; j++) {
					op.from[j]->get_whole(word);
					print_htmlspecialchars(word, ret);
				}
			}
		} else if (!added && (op.op == DiffOp<Word>::del || op.op == DiffOp<Word>::change)) {
			n = op.from.size();
			ret += "<span class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				op.from[j]->get_whole(word);
				print_htmlspecialchars(word, ret);
			}
			ret += "</span>";
		} else if (added && (op.op == DiffOp<Word>::add || op.op == DiffOp<Word>::change)) {
			n = op.to.size();
			ret += "<span class=\"diffchange diffchange-inline\">";
			for (j=0; j<n; j++) {
				op.to[j]->get_whole(word);
				print_htmlspecialchars(word, ret);
			}
			ret += "</span>";
		}
	}
}

void print_div_htmlspecialchars(const std::string & input, std::string & ret)
{
	// Wrap string in a <div> if it's not empty
	if (input.size() > 0) {
		ret.append("<div>");
		print_htmlspecialchars(input, ret);
		ret.append("</div>");
	}
}

void print_htmlspecialchars(const std::string & input, std::string & ret)
{
	size_t start = 0;
	size_t end = input.find_first_of("<>&");
	while (end != std::string::npos) {
		if (end > start) {
			ret.append(input, start, end - start);
		}
		switch (input[end]) {
			case '<':
				ret.append("&lt;");
				break;
			case '>':
				ret.append("&gt;");
				break;
			default /*case '&'*/:
				ret.append("&amp;");
		}
		start = end + 1;
		end = input.find_first_of("<>&", start);
	}
	// Append the rest of the string after the last special character
	if (start < input.size()) {
		ret.append(input, start, input.size() - start);
	}
}


inline bool my_istext(int ch)
{
	// Standard alphanumeric
	if ((ch >= '0' && ch <= '9') ||
	   (ch == '_') ||
	   (ch >= 'A' && ch <= 'Z') ||
	   (ch >= 'a' && ch <= 'z'))
	{
		return true;
	}
	// Punctuation and control characters
	if (ch < 0xc0) return false;
	// Thai, return false so it gets split up
	if (ch >= 0xe00 && ch <= 0xee7) return false;
	// Chinese/Japanese, same
	if (ch >= 0x3000 && ch <= 0x9fff) return false;
	if (ch >= 0x20000 && ch <= 0x2a000) return false;
	// Otherwise assume it's from a language that uses spaces
	return true;
}

inline bool my_isspace(int ch)
{
	return ch == ' ' || ch == '\t';
}

// Weak UTF-8 decoder
// Will return garbage on invalid input (overshort sequences, overlong sequences, etc.)
int next_utf8_char(std::string::const_iterator & p, std::string::const_iterator & charStart, 
		std::string::const_iterator end)
{
	int c;
	unsigned char byte;
	int bytes = 0;
	charStart = p;
	if (p == end) {
		return 0;
	}
	do {
		byte = (unsigned char)*p;
		if (byte < 0x80) {
			c = byte;
			bytes = 0;
		} else if (byte >= 0xc0) {
			// Start of UTF-8 character
			// If this is unexpected, due to an overshort sequence, we ignore the invalid
			// sequence and resynchronise here
		   	if (byte < 0xe0) {
				bytes = 1;
				c = byte & 0x1f;
			} else if (byte < 0xf0) {
				bytes = 2;
				c = byte & 0x0f;
			} else {
				bytes = 3;
				c = byte & 7;
			}
		} else if (bytes) {
			c <<= 6;
			c |= byte & 0x3f;
			--bytes;
		} else {
			// Unexpected continuation, ignore
		}
		++p;
	} while (bytes && p != end);
	return c;
}

// split a string into multiple tokens
void split_tokens(const std::string & text, std::vector<Word> &tokens)
{
	// Don't try to do a word-level diff on very long lines
	if (text.size() > MAX_DIFF_LINE) {
		tokens.push_back(Word(text.begin(), text.end(), text.end()));
		return;
	}
	
	std::string body, suffix;
	std::string::const_iterator bodyStart, bodyEnd, suffixEnd, charStart, p;
	int ch;
	p = text.begin();
	ch = next_utf8_char(p, charStart, text.end());
	while (ch) {
		// first group has three different opportunities:
		if (my_isspace(ch)) {
			// one or more whitespace characters
			bodyStart = charStart;
			while (my_isspace(ch)) {
				ch = next_utf8_char(p, charStart, text.end());
			}
			bodyEnd = charStart;
		} else if (my_istext(ch)) {
			// one or more text characters
			bodyStart = charStart;
			while (my_istext(ch)) {
				ch = next_utf8_char(p, charStart, text.end());
			}
			bodyEnd = charStart;
		} else {
			// one character, no matter what it is
			bodyStart = charStart;
			bodyEnd = p;
			ch = next_utf8_char(p, charStart, text.end());
		}
		
		// second group: any whitespace character
		while (my_isspace(ch)) {
			ch = next_utf8_char(p, charStart, text.end());
		}
		suffixEnd = charStart;
		tokens.push_back(Word(bodyStart, bodyEnd, suffixEnd));
	}
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
const char *wikidiff2_do_diff(const char *text1, const char *text2, int num_lines_context)
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

