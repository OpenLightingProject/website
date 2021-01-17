Linux Install
=============

Install dependencies
====================

You need a couple of libraries installed for everything to work
correctly. Some of these are available as packages in distros but others
need to be downloaded and built manually.

First you’ll need at least the following:

-   cppunit
-   uuid or ossp uuid
-   pkg-config
-   curses
-   lex (or flex)
-   yacc (or bison)
-   the protocol buffers library
    [http://code.google.com/p/protobuf/](https://code.google.com/p/protobuf/)
    (version 2.3.0 or later)
-   microhttpd <ftp://ftp.gnu.org/gnu/libmicrohttpd/> (if you want the
    web UI). You need version &gt;= 0.4.0 of microhttpd
-   avahi [\[1\]](https://www.avahi.org) if you want discovery enabled.

If you’re building from git you’ll also need the following:

-   libtool
-   automake
-   autoconf

Debian / Ubuntu
---------------

There is a fully packaged version of OLA you can just install, for info
see [OLA Debian / Ubuntu](http://opendmx.net/index.php/OLA_Debian_/_Ubuntu "OLA Debian / Ubuntu").
There’s also a more specific Ubuntu walkthrough for building
[The Newbie Guide for OLA on Ubuntu](http://opendmx.net/index.php/The_Newbie_Guide_for_OLA_on_Ubuntu "The Newbie Guide for OLA on Ubuntu").

Debian/Ubuntu users can install them with apt:

    sudo apt-get install libcppunit-dev libcppunit-1.13-0 uuid-dev pkg-config libncurses5-dev libtool autoconf automake g++ libmicrohttpd-dev 
     libmicrohttpd10 protobuf-compiler libprotobuf-lite10 python-protobuf libprotobuf-dev libprotoc-dev zlib1g-dev bison flex make libftdi-dev libftdi1 libusb-1.0-0-dev liblo-dev libavahi-client-dev python-numpy

Note: Some distributions may offer older versions of packages. For
example, libprotobuf-lite6 or libprotobuf-lite7 instead of
libprotobuf-lite8.

If you’re using Ubuntu 12.04 or later you can just use the command
above. In earlier versions of Ubuntu the version of libprotobuf is too
old, so you’ll need to install them by hand. You may also need to
install an older version of libmicrohttpd (libmicrohttpd9 rather than
libmicrohttpd10).

Centos 6 / RHEL 6 / Fedora 17
-----------------------------

Users of rpm based distributions can install them with yum (protobuf\*,
libmicrohttpd\* and libftdi\* are in the EPEL repository):

     sudo yum install flex bison protobuf protobuf-devel uuid-devel cppunit-devel protobuf-python libmicrohttpd-devel libusb-devel libftdi-devel libuuid-devel openslp-devel

(The remaining libs already come with the OS installation)

Other Distributions
-------------------

Install using your package manager, or build everything by hand

If you installed things by hand (rather than using your package
manager), you need to run ldconfig as root to pick up the new libraries

     sudo  ldconfig

Checkout or Download an Archive
===============================

You can either download a tarball, or pull the latest version from the
git repo

Tarball
-------

Download the most recent tarball from
[Github.](https://github.com/OpenLightingProject/ola/releases/latest)

Extract using

     tar -zxf ola-0.X.Y.tar.gz
     cd ola-0.X.Y

Git
---

If you don’t have **git** yet, you’ll need to install it with your
distro’s package manager. On Debian / Ubuntu run:

     sudo apt-get install git

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

Finally run ldconfig so you can use the new libraries.

     sudo ldconfig

Device drivers
==============

Note that, for some devices, it is necessary to install drivers for OLA
to work with them. For example, the [Open DMX USB](http://opendmx.net/index.php/Open_DMX_USB "Open DMX USB")
device needs an additional kernel module that could be built using the instuctions on
[LLA\_and\_Q\_Light\_Controller\_Ubuntu\_Tutorial](http://opendmx.net/index.php/LLA_and_Q_Light_Controller_Ubuntu_Tutorial "LLA and Q Light Controller Ubuntu Tutorial").
For other devices, refer to the corresponding device page on this wiki.

Known Issues
============

If you get an error like the following:

    /bin/sh ./libtool --tag=CC   --mode=compile gcc -DHAVE_CONFIG_H -I.   -I/opt/local/var/macports/software/protobuf-cpp/2.0.3_0/opt/local/include/  -g -O2 -c -o ltdl.lo ltdl.c
    ./libtool: line 464: CDPATH: command not found
    /Users/simonn/lighting/lla/libltdl/libtool: line 464: CDPATH: command not found
    /Users/simonn/lighting/lla/libltdl/libtool: line 1142: func_opt_split: command not found
    libtool: Version mismatch error.  This is libtool 2.2.6, but the
    libtool: definition of this LT_INIT comes from an older release.
    libtool: You should recreate aclocal.m4 with macros from libtool 2.2.6
    libtool: and run autoconf again.

Your system uses a different version of libtool. Run:

     libtoolize --ltdl -c -f

and then start from the autoreconf step again.

If you should get the following error try to fix it with one of
[two available solutions](https://groups.google.com/group/open-lighting/msg/72060f6327d30df6):

    Rpc.pb.cc: In copy constructor 'ola::rpc::RpcMessage::RpcMessage(const ola::rpc::RpcMessage&)': 
    Rpc.pb.cc:143: error: base class 'class google::protobuf::Message' should be explicitly initialized in the copy constructor

You should be able to prevent this by [editing `./src/Makefile.am`](https://groups.google.com/group/open-lighting/msg/c6d86d03dd74ed5b),
removing `-Werror` and then start from the autoreconfig step again.

If you get

    In file included from ./common/rdm/PidStoreLoader.h:32:0,
                     from common/rdm/PidStore.cpp:24:
    ./common/rdm/Pids.pb.h:17:2: error: #error This file was generated by an older version of protoc which is
     #error This file was generated by an older version of protoc which is
      ^
    ./common/rdm/Pids.pb.h:18:2: error: #error incompatible with your Protocol Buffer headers. Please
     #error incompatible with your Protocol Buffer headers.  Please
      ^
    ./common/rdm/Pids.pb.h:19:2: error: #error regenerate this file with a newer version of protoc.
     #error regenerate this file with a newer version of protoc.

Then you should run

    make clean

to clean out the old protobuf files.

Optional
========

Doxygen Documentation
---------------------

There is also an option to build the doxygen documentation! To do so you
will need to install [doxygen](http://www.doxygen.nl/manual/install.html).

Once you have installed Doxygen you may need to run ./configure in your
ola directory, so that it can generate the correct make file. To build
the docs just use:

     make doxygen-doc

You’ll have to run a webserver to get the experience. A simple way to do
this is to navigate to open-lighting/html and run:

     python -m SimpleHTTPServer

This opens a web server at your local IP address on port 8000. It can be
accessed through 127.0.0.1:80000 on your local machine as well.
