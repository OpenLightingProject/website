Install a Compiler
==================

The easiest is to install [Xcode.](https://developer.apple.com/xcode/)

You can use other compilers but that’s outside the scope of this
tutorial.

Install OLA Dependencies
========================

The easiest way is to install the dependencies using
[MacPorts](https://www.macports.org/).

Once you have MacPorts installed, first update its list of packages by
running the following command.

     sudo port -v selfupdate

Then run the following command to download and build the dependencies.

    sudo port install pkgconfig cppunit protobuf-cpp libmicrohttpd libusb py27-protobuf

You may need to change which Python protobuf port you install based on
the version of Python on your system. You can find that out by running

     python --version

On my system I get

     Python 2.7.1

So I install the py27-protobuf port. Remember which version you install
because you’ll need it in the next section.

Set some environment variables
==============================

Set $PATH to point to something sane, and fix some other environment
variables:

    export PATH="$PATH:/usr/local/bin/"
    export PKG_CONFIG_PATH="/opt/local/lib/pkgconfig:$PKG_CONFIG_PATH"
    export CPPFLAGS="-I/opt/local/include"
    export LDFLAGS="-L/opt/local/lib"
    export PYTHONPATH=/usr/local/lib/python2.7/site-packages/:/opt/local/Library/Frameworks/Python.framework/Versions/2.7/lib/python2.7/site-packages

You may need to tweak the PYTHONPATH depending on where the Python
protobuf was installed. You can find that out by running:

     port contents py27-protobuf

Make sure the port name matches the one you installed in the step above.

Checkout or Download an Archive
===============================

You can either download a tarball, or pull the latest version from the
git repo

Tarball
-----------

Download the most recent tarball from
[Github.](https://github.com/OpenLightingProject/ola/releases/latest)

Extract using

     tar -zxf ola-0.X.Y.tar.gz
     cd ola-0.X.Y

Git
---

If you don’t have **git** yet, you’ll need to install it, either through
Macports or Brew, or [download an
installer](https://git-scm.com/downloads).

     sudo port install git

Check out the git repo with the following command:

     git clone https://github.com/OpenLightingProject/ola.git ola
     cd ola

Run autoreconf
==============

If this is the first time run with -i to install the missing files

    autoreconf -i

Do the usual build steps
========================

You can pass additional options to ./configure . Run

     ./configure --help

to see all options. The most popular option is `--enable-python-libs` to
build the Python Client Module. If you want to use the RDM responder
tests add `--enable-rdm-tests`.

Once you’ve decided on the options, it’s time to build OLA. If you have
a multi-core machine, you can speed up the build by using `make -j N`. A
good value of N is the number of cores on your machine. On a MacBook Pro
(4 core) using `-j 4` reduced the build time from 5 minutes to 2.5
minutes.

    ./configure --enable-rdm-tests
    make
    make check
    sudo make install

Common Problems
===============

See [Common Problems When Building OLA on Mac](https://wiki.openlighting.org/index.php/Common_Problems_When_Building_OLA_on_Mac "Common Problems When Building OLA on Mac")
