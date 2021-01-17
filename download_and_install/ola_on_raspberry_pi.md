OLA on Raspberry Pi
===================

This tutorial describes how to get
[OLA](/ola) running on the
[Raspberry Pi](https://www.raspberrypi.org/).
The procedure described here is designed to get OLA up and running as
fast as possible. If you don’t trust the images below, or want to build
everything from scratch, you can install an image from the
[Raspberry Pi Site](https://www.raspberrypi.org/downloads)
and use the generic instructions for [Installing OLA](/ola/linuxinstall/) on Linux.  
There is plenty of information at the
[Raspberry Pi Wiki](http://elinux.org/RaspberryPiBoard).
The [Raspberry Pi Forum](https://www.raspberrypi.org/phpBB3/)
is a good place to ask for help on Raspberry Pi specific issues.  
<img src="/wp-content/uploads/2013/12/Raspi_Colour_R.png" class="alignnone size-full wp-image-472" width="166" height="200" alt="Raspi_Colour_R" />

Getting Started
===============

You’ll need the following:

-   A Raspberry Pi board. See the [Buying Guide](http://elinux.org/Buying_RPi)
    for how to purchase one.
-   An SD card, greater or equal to 4GB. Check the
    [SD Card Compatibility List](http://elinux.org/RPi_Verified_Peripherals#SD_cards)
    but don’t worry too much if your card isn’t listed there.
-   An SD card reader. Make sure it supports the SDHC (high capacity)
    cards.
-   A microUSB cable to provide power
-   A CAT5 network cable.
-   A Composite or HDMI monitor / TV to debug if things go wrong.
-   A computer with an SSH client and (optionally) Web Browser. You can
    use the Pi locally with a USB keyboard, but many people find it
    easier to access it from another machine.
-   A powered USB Hub, if you plan on using a USB DMX/RDM device. Many
    devices draw more current than the Raspberry Pi can support. See the
    [discussion](https://groups.google.com/forum/?fromgroups=#%21searchin/open-lighting/usb$20hub/open-lighting/mJpgweztVdE/pXm5SOihjmAJ)
    on the Open Lighting Group for more details.

Select your Image
=================

At this point you need to decide what image you want to use. The *GIT
Repo Image* allows you to track the latest changes, but requires you to
build the software yourself, which can take up to three hours. The
*Binary Package Image* uses the pre-built binary packages for each
release. The images can be found at http://dl.openlighting.org/.

We recommend the *Binary Package Image* if you’re starting out.

New images are released every month or two, so remember to update to
take advantage of new features and bug fixes.

GIT Repo Image
--------------

This tracks the [Git Repo](https://github.com/OpenLightingProject/ola),
which means you can always use the very latest version of the code. The
downside of using this option is that you have the build the code
yourself (which takes time) and configuration is left up to you. It’s
more flexible than the Binary Package version, but does require some
extra work.

Download the latest ola-git-NNNNNNNN.zip image.

Binary Package Image
--------------------

[Raspbian](https://www.raspbian.org/)
is an armhf port of Debian specifically built for the Raspberry Pi. It
offers slightly better performance than the stock Debian arm port.

Use this option if you prefer a more stable system. The pre-compiled
packages are usually updated once a month and you don’t need to spend
time building OLA from source.

Download the latest raspbian-ola-X.Y.Z.zip image.

Copying the Image
=================

Once you have selected an image, unzip it, and then you need to copy it
to your SD card. The [Raspberry Pi Wiki](http://elinux.org/RPi_Easy_SD_Card_Setup)
page has detailed instructions for each platform.

This can take a while if you have a slow SD Card (see
[SDHC Speeds](https://en.wikipedia.org/wiki/Secure_Digital#Speed_Class_Rating)).
On my Linux machine with a Class 2 card it took 14 minutes to write the
3.9G image, a Class 4 card took 11 minutes. On a Macbook Pro, using the
onboard SD-Card slot it took 153 seconds to write the image using dd to
a Class 4 card. Your speeds are likely to vary between machines.

Starting Up
===========

Insert the card into the Raspberry Pi, make sure it’s connected to a
network which has a DHCP server running, and apply power. If you have a
monitor attached you should see it booting. You’ll then need to
determine the IP address of your Pi. If you have a screen attached it
should be shown just before the login prompt. Otherwise you can check
your DHCP server logs and see which address was assigned. This example
assumes an IP address of 192.168.1.200.

Login using SSH
---------------------------------------------------------------------------------------------------------

From your other machine, start your SSH client and SSH to your Pi with
username “pi,” no quotes. On Linux or Mac you can use the Terminal
application and type:

    ssh [email protected]

The password is ‘openlighting’ (no quotes).

If you’re on Windows you can download
[PuTTY](http://www.chiark.greenend.org.uk/%7Esgtatham/putty/) and use that.

You should see the login message and get a shell prompt. If that doesn’t
work, you may need to restart (pull the power and plug it in again).
Sometimes the Pi gets into a weird state on the first boot.

Security
--------

By default, the image comes with a SSH Key installed for Simon to access
the system *only* if you configure your router and tell Simon what the
address is. If you trust me (and your probably do since you’re running
my code) you can leave this on. Otherwise you can delete my key by
running:

    rm .ssh/authorized_keys

Next change the password:

    passwd
    Changing password for ola.
    (current) UNIX password: 
    Enter new UNIX password: 
    Retype new UNIX password:

Enable Turbo Mode (Optional)
----------------------------

The Raspberry Pi supports overclocking, which can increase the
performance of your system. You can configure this by running

    sudo raspi-config

and then selecting the *overclock* option. I (Simon) normally run with
the Turbo option and haven’t experienced any problems.

Expand the Root Partition (Optional)
------------------------------------

If your SD card is larger than 4GB you can expand the root partition to
use all of the available space. Again use

    sudo raspi-config

and then choose the *expand\_rootfs* option.

Installing (git image only)
---------------------------

The git image is a pre-built clone of the git repo. The ‘make install’
step hasn’t been run, so before you can use OLA you’ll need to run the
following:

    cd ~/open-lighting
    sudo make install
    sudo ldconfig

Then you can launch olad with:

    olad -l 3

Updating
========

It’s best to always use the latest version of OLA. Even immediately
after downloading an image there may be updates to apply so we recommend
you do this before you start using the Pi. To update your install follow
one of the methods below, depending on what image you used.

it Repo
-------

Once you’re logged in, run:

    cd open-lighting
    git pull
    autoreconf
    ./configure --enable-rdm-tests
    make
    sudo make install
    sudo ldconfig

The make step can take a few hours.

If you see errors of the form

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

Binary Package Image
--------------------

Run this:

    sudo apt-get update
    sudo apt-get upgrade

Connecting to OLA
=================

At this point everything should be running. You can access the OLA web
UI by opening a web browser and typing:

http://192.168.1.200:9090

Of course you should replace 192.168.1.200 with the IP Address of your
device.

Config and Log files
====================

If you’re using the pre-built image or Debian packages, the OLA config
files are in `/var/lib/ola/conf`. The logs are written to
`/var/log/syslog`.

Related Information
===================

If you’re interested in how these images differ from the image released
by the Raspberry Pi Foundation, see [Building a Custom Raspbian
Image](https://wiki.openlighting.org/index.php/Building_a_Custom_Raspbian_Image "Building a Custom Raspbian Image")
