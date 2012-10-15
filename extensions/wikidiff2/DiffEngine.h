/**
 * GPL blah blah, see below for history
 */

#ifndef DIFFENGINE_H
#define DIFFENGINE_H

//#define USE_JUDY

#include <vector>
#include <map>
#include <set>
#include <utility>
#include <algorithm>
#include <cassert>

#ifdef USE_JUDY
#include "JudyHS.h"
#endif

#include "wikidiff2.h"

/**
 * Diff operation
 * 
 * from and to are vectors containing pointers to the objects passed in from_lines and to_lines
 *
 * op is one of the following
 *    copy:    A sequence of lines (in from and to) which are the same in both files. 
 *    del:     A sequence of lines (in from) which were in the first file but not the second.
 *    add:     A sequence of lines (in to) which were in the second file but not the first.
 *    change:  A sequence of lines which are different between the two files. Lines from the 
 *             first file are in from, lines from the second are in to. The two vectors need 
 *             not be the same length.
 */
template<typename T>
class DiffOp
{
	public:
		typedef std::vector<const T*, WD2_ALLOCATOR<const T*> > PointerVector;
		DiffOp(int op_, const PointerVector & from_, const PointerVector & to_)
			: op(op_), from(from_), to(to_) {}

		enum {copy, del, add, change};
		int op;
		PointerVector from;
		PointerVector to;
};

/**
 * Basic diff template class. After construction, edits will contain a vector of DiffOpTemplate
 * objects representing the diff
 */
template<typename T>
class Diff
{
	public:
		typedef std::vector<T, WD2_ALLOCATOR<T> > ValueVector;
		typedef std::vector<DiffOp<T>, WD2_ALLOCATOR<T> > DiffOpVector;

		Diff(const ValueVector & from_lines, const ValueVector & to_lines);
		
		virtual void add_edit(const DiffOp<T> & edit) {
			edits.push_back(edit); 
		}
		unsigned size() { return edits.size(); }
		DiffOp<T> & operator[](int i) {return edits[i];}

		DiffOpVector edits;
};
/**
 * Class used internally by Diff to actually compute the diffs.
 *
 * The algorithm used here is mostly lifted from the perl module
 * Algorithm::Diff (version 1.06) by Ned Konz, which is available at:
 *	 http://www.perl.com/CPAN/authors/id/N/NE/NEDKONZ/Algorithm-Diff-1.06.zip
 *
 * More ideas are taken from:
 *	 http://www.ics.uci.edu/~eppstein/161/960229.html
 *
 * Some ideas are (and a bit of code) are from from analyze.c, from GNU
 * diffutils-2.7, which can be found at:
 *	 ftp://gnudist.gnu.org/pub/gnu/diffutils/diffutils-2.7.tar.gz
 *
 * This implementation is largely due to Geoffrey T. Dairiki, who wrote this 
 * diff engine for phpwiki 1-3.3. It was then adopted by MediaWiki. 
 *
 * Finally, it was ported to C++ by Tim Starling in February 2006
 *
 * @access private
 */

template<typename T>
class _DiffEngine 
{
	public:
		// Vectors
		typedef std::vector<bool> BoolVector; // skip the allocator here to get the specialisation
		typedef std::vector<const T*, WD2_ALLOCATOR<const T*> > PointerVector;
		typedef std::vector<T, WD2_ALLOCATOR<T> > ValueVector;
		typedef std::vector<int, WD2_ALLOCATOR<int> > IntVector;
		typedef std::vector<std::pair<int, int>, WD2_ALLOCATOR<std::pair<int, int> > > IntPairVector;

		// Maps
#ifdef USE_JUDY
		typedef JudyHS<IntVector> MatchesMap;
#else
		typedef std::map<T, IntVector, std::less<T>, WD2_ALLOCATOR<IntVector> > MatchesMap;
#endif

		// Sets
		typedef std::set<int, std::less<int>, WD2_ALLOCATOR<int> > IntSet;
#ifdef USE_JUDY
		typedef JudySet ValueSet;
#else
		typedef std::set<T, std::less<T>, WD2_ALLOCATOR<T> > ValueSet;
#endif

		_DiffEngine() : done(false) {}
		void clear();
		void diff (const ValueVector & from_lines, 
				const ValueVector & to_lines, Diff<T> & diff);
		int _lcs_pos (int ypos);
		void _compareseq (int xoff, int xlim, int yoff, int ylim);
		void _shift_boundaries (const ValueVector & lines, BoolVector & changed, 
				const BoolVector & other_changed);
	protected:
		int _diag (int xoff, int xlim, int yoff, int ylim, int nchunks, 
				IntPairVector & seps);
		
		BoolVector xchanged, ychanged;
		PointerVector xv, yv;
		IntVector xind, yind;
		IntVector seq;
		IntSet in_seq;
		int lcs;
		bool done;
		enum {MAX_CHUNKS=8};
};

//-----------------------------------------------------------------------------
// _DiffEngine implementation
//-----------------------------------------------------------------------------
template<typename T>
void _DiffEngine<T>::clear() 
{
	xchanged.clear();
	ychanged.clear();
	xv.clear();
	yv.clear();
	xind.clear();
	yind.clear();
	seq.clear();
	in_seq.clear();
	done = false;
}

template<typename T>
void _DiffEngine<T>::diff (const ValueVector & from_lines, 
		const ValueVector & to_lines, Diff<T> & diff) 
{
	int n_from = (int)from_lines.size();
	int n_to = (int)to_lines.size();

	// If this diff engine has been used before for a diff, clear the member variables
	if (done) {
		clear();
	} 
	xchanged.resize(n_from);
	ychanged.resize(n_to);
	seq.resize(std::max(n_from, n_to) + 1);

	// Skip leading common lines.
	int skip, endskip;
	for (skip = 0; skip < n_from && skip < n_to; skip++) {
		if (from_lines[skip] != to_lines[skip])
			break;
		xchanged[skip] = ychanged[skip] = false;
	}
	// Skip trailing common lines.
	int xi = n_from, yi = n_to;
	for (endskip = 0; --xi > skip && --yi > skip; endskip++) {
		if (from_lines[xi] != to_lines[yi])
			break;
		xchanged[xi] = ychanged[yi] = false;
	}

	// Ignore lines which do not exist in both files.
	ValueSet xhash, yhash;
	for (xi = skip; xi < n_from - endskip; xi++) {
		xhash.insert(from_lines[xi]);
	}

	for (yi = skip; yi < n_to - endskip; yi++) {
		const T & line = to_lines[yi];
		if ( (ychanged[yi] = (xhash.find(line) == xhash.end())) )
			continue;
		yhash.insert(line);
		yv.push_back(&line);		
		yind.push_back(yi);
	}
	for (xi = skip; xi < n_from - endskip; xi++) {
		const T & line = from_lines[xi];
		if ( (xchanged[xi] = (yhash.find(line) == yhash.end())) )
			continue;
		xv.push_back(&line);
		xind.push_back(xi);
	}

	// Find the LCS.
	_compareseq(0, xv.size(), 0, yv.size());

	// Merge edits when possible
	_shift_boundaries(from_lines, xchanged, ychanged);
	_shift_boundaries(to_lines, ychanged, xchanged);

	// Compute the edit operations.
	xi = yi = 0;
	while (xi < n_from || yi < n_to) {
		assert(yi < n_to || xchanged[xi]);
		assert(xi < n_from || ychanged[yi]);

		// Skip matching "snake".
		PointerVector del;
		PointerVector add;
		PointerVector empty;
		while (xi < n_from && yi < n_to && !xchanged[xi] && !ychanged[yi]) {
			del.push_back(&from_lines[xi]);
			add.push_back(&to_lines[yi]);
			++xi;
			++yi;
		}
		if (del.size()) {
			diff.add_edit(DiffOp<T>(DiffOp<T>::copy, del, add));
			del.clear();
			add.clear();
		}

		// Find deletes & adds.
		while (xi < n_from && xchanged[xi])
			del.push_back(&from_lines[xi++]);

		while (yi < n_to && ychanged[yi])
			add.push_back(&to_lines[yi++]);

		if (del.size() && add.size())
			diff.add_edit(DiffOp<T>(DiffOp<T>::change, del, add));
		else if (del.size())
			diff.add_edit(DiffOp<T>(DiffOp<T>::del, del, empty));
		else if (add.size())
			diff.add_edit(DiffOp<T>(DiffOp<T>::add, empty, add));
	}

	done = true;
}

/* Divide the Largest Common Subsequence (LCS) of the sequences
 * [XOFF, XLIM) and [YOFF, YLIM) into NCHUNKS approximately equally
 * sized segments.
 *
 * Returns (LCS, SEPS). LCS is the length of the LCS. SEPS is an
 * array of NCHUNKS+1 (X, Y) indexes giving the diving points between
 * sub sequences.  The first sub-sequence is contained in [X0, X1),
 * [Y0, Y1), the second in [X1, X2), [Y1, Y2) and so on.  Note
 * that (X0, Y0) == (XOFF, YOFF) and
 * (X[NCHUNKS], Y[NCHUNKS]) == (XLIM, YLIM).
 *
 * This function assumes that the first lines of the specified portions
 * of the two files do not match, and likewise that the last lines do not
 * match.  The caller must trim matching lines from the beginning and end
 * of the portions it is going to specify.
 */
template <typename T>
int _DiffEngine<T>::_diag (int xoff, int xlim, int yoff, int ylim, int nchunks, 
		IntPairVector & seps) 
{
	using std::swap;
	using std::make_pair;
	using std::copy;
	bool flip = false;
	MatchesMap ymatches;

	if (xlim - xoff > ylim - yoff) {
		// Things seems faster (I'm not sure I understand why)
		// when the shortest sequence in X.
		flip = true;
		swap(xoff, yoff);
		swap(xlim, ylim);
	}

	if (flip)
		for (int i = ylim - 1; i >= yoff; i--)
			ymatches[*xv[i]].push_back(i);
	else
		for (int i = ylim - 1; i >= yoff; i--)
			ymatches[*yv[i]].push_back(i);

	int nlines = ylim - yoff;
	lcs = 0;
	seq[0] = yoff - 1;
	in_seq.clear();

	// 2-d array, line major, chunk minor
	IntVector ymids(nlines * nchunks);

	int numer = xlim - xoff + nchunks - 1;
	int x = xoff, x1, y1;
	for (int chunk = 0; chunk < nchunks; chunk++) {
		if (chunk > 0)
			for (int i = 0; i <= lcs; i++) 
				ymids.at(i * nchunks + chunk-1) = seq[i];

		x1 = xoff + (int)((numer + (xlim-xoff)*chunk) / nchunks);
		for ( ; x < x1; x++) {
			const T & line = flip ? *yv[x] : *xv[x];
#ifdef USE_JUDY
			IntVector * pMatches = ymatches.Get(line);
			if (!pMatches)
				continue;
#else
			typename MatchesMap::iterator iter = ymatches.find(line);
			if (iter == ymatches.end())
				continue;
			IntVector * pMatches = &(iter->second);
#endif
			IntVector::iterator y;
			int k = 0;
			
			for (y = pMatches->begin(); y != pMatches->end(); ++y) {
				if (!in_seq.count(*y)) {
					k = _lcs_pos(*y);
					assert(k > 0);
					copy(ymids.begin() + (k-1) * nchunks, ymids.begin() + k * nchunks, 
							ymids.begin() + k * nchunks);
					++y;
					break;
				}
			}
			for ( ; y != pMatches->end(); ++y) {
				if (*y > seq[k-1]) {
					assert(*y < seq[k]);
					// Optimization: this is a common case:
					//	next match is just replacing previous match.
					in_seq.erase(seq[k]);
					seq[k] = *y;
					in_seq.insert(*y);
				} else if (!in_seq.count(*y)) {
					k = _lcs_pos(*y);
					assert(k > 0);
					copy(ymids.begin() + (k-1) * nchunks, ymids.begin() + k * nchunks, 
							ymids.begin() + k * nchunks);
				}
			}
		}
	}

	seps.clear();
	seps.resize(nchunks + 1);
	
	seps[0] = flip ? make_pair(yoff, xoff) : make_pair(xoff, yoff);
	IntVector::iterator ymid = ymids.begin() + lcs * nchunks;
	for (int n = 0; n < nchunks - 1; n++) {
		x1 = xoff + (numer + (xlim - xoff) * n) / nchunks;
		y1 = ymid[n] + 1;
		seps[n+1] = flip ? make_pair(y1, x1) : make_pair(x1, y1);
	}
	seps[nchunks] = flip ? make_pair(ylim, xlim) : make_pair(xlim, ylim);
	return lcs;
}

template <typename T>
int _DiffEngine<T>::_lcs_pos (int ypos) {
	int end = lcs;
	if (end == 0 || ypos > seq[end]) {
		seq[++lcs] = ypos;
		in_seq.insert(ypos);
		return lcs;
	}

	int beg = 1;
	while (beg < end) {
		int mid = (beg + end) / 2;
		if ( ypos > seq[mid] )
			beg = mid + 1;
		else
			end = mid;
	}

	assert(ypos != seq[end]);

	in_seq.erase(seq[end]);
	seq[end] = ypos;
	in_seq.insert(ypos);
	return end;
}

/* Find LCS of two sequences.
 *
 * The results are recorded in the vectors {x,y}changed[], by
 * storing a 1 in the element for each line that is an insertion
 * or deletion (ie. is not in the LCS).
 *
 * The subsequence of file 0 is [XOFF, XLIM) and likewise for file 1.
 *
 * Note that XLIM, YLIM are exclusive bounds.
 * All line numbers are origin-0 and discarded lines are not counted.
 */
template <typename T>
void _DiffEngine<T>::_compareseq (int xoff, int xlim, int yoff, int ylim) {
	using std::pair;

	IntPairVector seps;
	int lcs;
	
	// Slide down the bottom initial diagonal.
	while (xoff < xlim && yoff < ylim && *xv[xoff] == *yv[yoff]) {
		++xoff;
		++yoff;
	}

	// Slide up the top initial diagonal.
	while (xlim > xoff && ylim > yoff && *xv[xlim - 1] == *yv[ylim - 1]) {
		--xlim;
		--ylim;
	}

	if (xoff == xlim || yoff == ylim)
		lcs = 0;
	else {
		// This is ad hoc but seems to work well.
		//nchunks = sqrt(min(xlim - xoff, ylim - yoff) / 2.5);
		//nchunks = max(2,min(8,(int)nchunks));
		int nchunks = std::min(MAX_CHUNKS-1, std::min(xlim - xoff, ylim - yoff)) + 1;
		lcs = _diag(xoff, xlim, yoff, ylim, nchunks, seps);
	}

	if (lcs == 0) {
		// X and Y sequences have no common subsequence:
		// mark all changed.
		while (yoff < ylim)
			ychanged[yind[yoff++]] = true;
		while (xoff < xlim)
			xchanged[xind[xoff++]] = true;
	} else {
		// Use the partitions to split this problem into subproblems.
		IntPairVector::iterator pt1, pt2;
		pt1 = pt2 = seps.begin();
		while (++pt2 != seps.end()) {
			_compareseq (pt1->first, pt2->first, pt1->second, pt2->second);
			pt1 = pt2;
		}
	}
}

/* Adjust inserts/deletes of identical lines to join changes
 * as much as possible.
 *
 * We do something when a run of changed lines include a
 * line at one end and has an excluded, identical line at the other.
 * We are free to choose which identical line is included.
 * `compareseq' usually chooses the one at the beginning,
 * but usually it is cleaner to consider the following identical line
 * to be the "change".
 *
 * This is extracted verbatim from analyze.c (GNU diffutils-2.7).
 */
template <typename T>
void _DiffEngine<T>::_shift_boundaries (const ValueVector & lines, BoolVector & changed, 
		const BoolVector & other_changed) 
{
	int i = 0;
	int j = 0;

	int len = (int)lines.size();
	int other_len = (int)other_changed.size();

	while (1) {
		/*
		 * Scan forwards to find beginning of another run of changes.
		 * Also keep track of the corresponding point in the other file.
		 *
		 * Throughout this code, i and j are adjusted together so that
		 * the first i elements of changed and the first j elements
		 * of other_changed both contain the same number of zeros
		 * (unchanged lines).
		 * Furthermore, j is always kept so that j == other_len or
		 * other_changed[j] == false.
		 */
		while (j < other_len && other_changed[j])
			j++;

		while (i < len && ! changed[i]) {
			i++; j++;
			while (j < other_len && other_changed[j])
				j++;
		}

		if (i == len)
			break;

		int start = i, runlength, corresponding;

		// Find the end of this run of changes.
		while (++i < len && changed[i])
			continue;

		do {
			/*
			 * Record the length of this run of changes, so that
			 * we can later determine whether the run has grown.
			 */
			runlength = i - start;

			/*
			 * Move the changed region back, so long as the
			 * previous unchanged line matches the last changed one.
			 * This merges with previous changed regions.
			 */
			while (start > 0 && lines[start - 1] == lines[i - 1]) {
				changed[--start] = true;
				changed[--i] = false;
				while (start > 0 && changed[start - 1])
					start--;
				while (other_changed[--j])
					continue;
			}

			/*
			 * Set CORRESPONDING to the end of the changed run, at the last
			 * point where it corresponds to a changed run in the other file.
			 * CORRESPONDING == LEN means no such point has been found.
			 */
			corresponding = j < other_len ? i : len;

			/*
			 * Move the changed region forward, so long as the
			 * first changed line matches the following unchanged one.
			 * This merges with following changed regions.
			 * Do this second, so that if there are no merges,
			 * the changed region is moved forward as far as possible.
			 */
			while (i < len && lines[start] == lines[i]) {
				changed[start++] = false;
				changed[i++] = true;
				while (i < len && changed[i])
					i++;

				j++;
				if (j < other_len && other_changed[j]) {
					corresponding = i;
					while (j < other_len && other_changed[j])
						j++;
				}
			}
		} while (runlength != i - start);

		/*
		 * If possible, move the fully-merged run of changes
		 * back to a corresponding run in the other file.
		 */
		while (corresponding < i) {
			changed[--start] = 1;
			changed[--i] = 0;
			while (other_changed[--j])
				continue;
		}
	}
}
//-----------------------------------------------------------------------------
// Diff implementation
//-----------------------------------------------------------------------------

template<typename T>
Diff<T>::Diff(const ValueVector & from_lines, const ValueVector & to_lines)
{
	_DiffEngine<T> engine;
	engine.diff(from_lines, to_lines, *this);
}

#endif
