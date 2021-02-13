OLA on Raspberry Pi
===================

This tutorial describes how to get OLA running on the
[Raspberry Pi](https://www.raspberrypi.org/). The procedure described here is designed to get OLA up and running as
easily as possible. There is plenty of information on
the [Raspberry Pi Docs](https://www.raspberrypi.org/documentation/).
The [Raspberry Pi Forum](https://www.raspberrypi.org/forums/) is a good place to ask for help on Raspberry Pi specific
issues.

Getting Started
===============

See the official [setup guide](https://www.raspberrypi.org/documentation/setup/) for hardware requirements.

- A monitor is not strictly required to use OLA, but one can be helpful for debugging purposes.
- If you plan on using a USB DMX interface that does not use its own power supply, you will also need a powered USB hub.
  The Raspberry Pi hardware cannot supply enough power over USB to meet the needs of most USB DMX interfaces.
- A wired network connection is required when using OLA with any network protocols. Remember, DMX over WiFi is not Wireless DMX!

Installation
=============

OLA is easily available when using [Raspberry Pi OS](https://www.raspberrypi.org/software/operating-systems/). If your
Raspberry Pi will only be used for OLA, use the "Raspberry Pi OS Lite" operating system.

Follow the official installation instructions
[here](https://www.raspberrypi.org/documentation/installation/installing-images/) to install the OS.

Starting Up
===========

If you don't have a display and keyboard, follow the SSH instructions
[here](https://www.raspberrypi.org/documentation/remote-access/ssh/README.md). This guide will assume you are typing
directly into the Raspberry Pi or have established an SSH session.

Installing
----------

As with other Debian Linux systems, installing OLA can be performed by running

    sudo apt-get update
    sudo apt-get install ola

in the terminal.

Reboot the device with `sudo reboot` to begin using OLA.

Updating
--------

It’s best to always use the latest version of OLA. To update your install, run

    sudo apt-get update
    sudo apt-get upgrade

in the terminal.

Connecting
==========

At this point everything should be running. You can access the OLA web UI by opening a web browser and typing:

    http://<ip_address>:9090

Config and Log files
====================

Config files are in `/etc/ola`. OLA logs to syslog, so logs are in `/var/log/syslog`.
