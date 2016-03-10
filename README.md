# MAINTAINER
H W Tovetjärn (totte) <totte@chakraos.org>

# CONTRIBUTORS

# LICENSE
See each subdirectory for license information. The bugtracker is
Flyspray, the CCR is based on AUR, the forum is FluxBB, Home is
original, the blog is Serendipity, the Packages is original, the
wiki is MediaWiki.

# DEPENDENCIES
To run on a Debian "Jessie" system:

* imagemagick
* imagemagick-common
* mysql-client
* mysql-client-5.5
* mysql-common
* nginx
* nginx-common
* nginx-full
* php-apc
* php-geshi
* php-pear
* php5-cli
* php5-common
* php5-dev
* php5-fpm
* php5-gd
* php5-imagick
* php5-intl
* php5-mcrypt
* php5-memcache
* php5-memcached
* php5-mysql

# CODE STYLE
Stick to tabs, not spaces, for PHP.

# DEVELOPMENT
Discussion regarding the development of this website takes place in the channel
\#chakra-devel on Freenode, on the mailing list chakra-devel@googlegroups.com and
on our [bug tracker](https://chakraos.org/bugtracker/index.php?project=2). If
you wish to notify us of a security issue or something else that is sensitive
you can send an e-mail to totte@chakraos.org.

The master branch is automatically deployed to chakraos.org on each push, and
the development branch is automatically deployed to development.chakraos.org on
each push.

New patches should always be based on the latest code on the development branch
in the [official git repository](git.chakraos.org/website.git), unless your
patch concerns a bug on the master branch. In that case, it should be on the
master branch.

Patches should be posted on our
[Review Board](https://chakraos.org/reviewboard). We’ll review the patches
there, and eventually submit the change if we agree it belongs in the codebase.

We do not accept patches to the mailing lists, on our bug tracker, or through
pull requests. If a patch is posted to these locations, we will ask that it be
resubmitted to our Review Board.

Before submitting patches, please make sure the code adheres to the CODE STYLE
described above. You should also read these guides on
[keeping commits clean](https://www.reviewboard.org/docs/codebase/dev/git/clean-commits/) and
[writing good change descriptions](https://www.reviewboard.org/docs/codebase/dev/writing-good-descriptions/).


# PALETTE

* Dark blue: #2C5D87
* Not-as-dark blue: rgb(50, 118, 177)

# USAGE

Static pages for official information on:

* What Chakra is
* Who the contributors, sponsors and donors are
* How to donate
* Where to download Chakra
* How to verify the downloaded file
* Code of Conduct/Policies/Protocols
* How and who to contact
* Legal information


A blog, /news (Serendipity) for announcing:

* New releases
* Package updates of significance
* Significant changes to the infrastructure


A wiki, /wiki (MediaWiki) for instructions:

* Frequently Asked Questions (FAQ)
* Glossary
* How to download Chakra (torrent, magnet, http)
* How to create a bootable medium
* How to install Chakra
* How to use pacman
* How to use octopi
* How to use mirrors
* How to build packages using PKGBUILDs and makepkg
* How to use the CCR
* How to troubleshoot
* How to report bugs


A forum, /forum (FluxBB) for technical support:

* General
	* Announcements (minor such)
	* Discussion
* Support
	* Beginner
	* Stable
	* Testing
	* Unstable
	* Live Media & Installation
	* Hardware
	* CCR
	* Other languages
* Archive
	* Bikeshed
	* Dustbin
	* Comunità Chakra Italiana


A bugtracker, /bugtracker (Flyspray) for reporting:

* Packages
	* Outdated packages
	* Broken packages
	* Missing packages
	* Misplaced packages
	* Feature requests
	* Bug reports
	* Package requests (usually popular packages from the CCR)
* Live Media issues
* Chakra Build System (CBS) issues
* Akabei issues
* Kapudan issues
* Kinky issues
* Website issues
* Infrastructure
	* Access requests
	* Promotion requests
	* General issues

A CCR, /ccr (CCR) for users to upload and vote on source tarballs

A code review application, /reviewboard (Review Board) for code review

A pastebin, /pastebin (dpaste) for pasting text snippets
