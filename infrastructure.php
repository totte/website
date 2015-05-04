<div class="col-md-12">
    <h1>Infrastructure</h1>
    <ul class="list-inline">
        <li><a href="#bulbasaur">bulbasaur</a></li>
        <li><a href="#charmander">charmander</a></li>
        <li><a href="#squirtle">squirtle</a></li>
        <li><a href="#pidgey">pidgey</a></li>
        <li><a href="#rattata">rattata</a></li>
        <li><a href="#snorlax">snorlax</a></li>
        <li><a href="#abra">abra</a></li>
        <li><a href="#eevee">eevee</a></li>
        <li><a href="#sandshrew">sandshrew</a></li>
        <li><a href="#oddish">oddish</a></li>
        <li><a href="#news">News (app)</a></li>
        <li><a href="#forum">Forum (app)</a></li>
        <li><a href="#wiki">Wiki (app)</a></li>
        <li><a href="#ccr">CCR (app)</a></li>
        <li><a href="#bugtracker">Bugtracker (app)</a></li>
        <li><a href="#reviewboard">Review Board (app)</a></li>
        <li><a href="#git">git</a></li>
    </ul>
    <p>All servers run Debian with openssh-server, munin, vnstat, apticron, logwatch, sudo, zsh, python3, python3-pip, vim, exim4, rsync, git, python, python-pip, ufw, libpam-cracklib, iftop, iotop, htop, unzip, iptraf, whowatch, nethogs ...</p>
    <p>Root login via SSH is disabled on all servers, one may only log in with an authorized key.</p>
    <hr />
    <a name="bulbasaur"><h2>bulbasaur <small>domain 0</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>bulbasaur.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>N/A</dd>
        <dt>rDNS set</dt><dd>Yes</dd>
        <dt>IP</dt><dd>5.175.233.117</dd>
        <dt>Processor cores</dt><dd>4 (physical)</dd>
        <dt>Memory</dt><dd>1 GB</dd>
        <dt>Disk: swap</dt><dd>4 GB</dd>
        <dt>Disk: /</dt><dd>16 GB</dd>
        <dt>Disk: /home</dt><dd>8 GB</dd>
    </dl>
    <p>This is the dedicated server we rent from Host1Plus with the additional benefit of an anti-DDoS system which filters the traffic for all of our services - if the attack is too heavy the origin IP is null-routed. The machine has 8 GB DDR3 memory, 2x 1 TB HDD in RAID1 (Adaptec AAC-RAID rev 09), Intel i7 4 cores (8 threads) 1600 MHz, unlimited bandwidth, 100mbps port speed, 5 static IPs and runs Xen as dom0, acting as a network bridge. CPUs 0 and 1 are dedicated to this machine, the rest are available for the guests. It currently hosts four paravirtualized guests.</p>
    <p><em>/etc/default/grub</em></p>
    <pre class="pre-scrollable">GRUB_DEFAULT=0
GRUB_TIMEOUT=5
GRUB_DISTRIBUTOR=`lsb_release -i -s 2> /dev/null || echo Debian`
GRUB_CMDLINE_LINUX_DEFAULT="quiet"
GRUB_CMDLINE_LINUX=""
GRUB_CMDLINE_XEN_DEFAULT="dom0_max_vcpus=4 dom0_vcpus_pin dom0_mem=1024M"
</pre>
    <p><em>/etc/xen/xend-config.sxp</em></p>
    <pre class="pre-scrollable">(vif-script 'vif-bridge bridge=br0')
(dom0-min-mem 1024)
(enable-dom0-ballooning no)
(total_available_memory 0) 
(dom0-cpus 4)
</pre>
    <h3>Firewall</h3>
    <p>Incoming: All denied save for SSH access from specific hosts.</p>
    <p>Outgoing: All allowed.</p>
    <h3>Services</h3>
    <ul>
        <li>SSH</li>
    </ul>
    <h3>Important configuration files</h3>
    <ul>
        <li>/etc/ssh/sshd_config</li>
        <li>/etc/network/interfaces</li>
        <li>/etc/sysctl.conf</li>
        <li>/etc/pam.d/common-password</li>
        <li>/etc/login.defs</li>
        <li>/etc/skel/.ssh/authorized_keys</li>
        <li>/etc/hosts.allow</li>
        <li>/etc/hosts.deny</li>
        <li>/etc/rsyslog.conf</li>
        <li>/etc/default/grub</li>
        <li>/etc/xen/xend-config.sxp</li>
        <li>/etc/xen/charmander.chakraos.org?</li>
        <li>/etc/xen/squirtle.chakraos.org?</li>
        <li>/etc/xen/pidgey.chakraos.org?</li>
        <li>/etc/xen/rattata.chakraos.org?</li>
        <li></li>
    </ul>
    <h3>Important log files</h3>
    <ul>
        <li>/var/log/auth.log</li>
        <li>/var/log/ufw.log</li>
        <li>/var/log/syslog</li>
        <li>/var/log/xen/xend.log</li>
    </ul>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>UID</th>
            <th>User</th>
            <th>Groups</th>
            <th>Key</th>
            <th>Role</th>
            <th>Cronjobs</th>
            <th>Owned directories</th>
        </tr>
        <tr>
            <td></td>
            <td>totte</td>
            <td>sudo</td>
            <td>Yes</td>
            <td>Administrator</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>inkane</td>
            <td>sudo</td>
            <td>Yes</td>
            <td>Administrator (backup)</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <hr />
    <a name="charmander"><h2>charmander <small>web server</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>charmander.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>www.chakraos.org</dd>
        <dt>rDNS set</dt><dd>Yes</dd>
        <dt>IP</dt><dd>5.175.233.118</dd>
        <dt>Processor cores</dt><dd>1 (virtual)</dd>
        <dt>Memory</dt><dd>2 GB</dd>
        <dt>Disk: swap</dt><dd>4 GB</dd>
        <dt>Disk: /</dt><dd>32 GB</dd>
        <dt>Disk: /home</dt><dd>N/A</dd>
    </dl>
    <p>The first PV guest, it runs nginx, gunicorn and php-fpm to serve the website.</p>
    <pre class="pre-scrollable">bootloader = '/usr/lib/xen-4.1/bin/pygrub'
cpus        = '4-7'
vcpus       = '1'
memory      = '2048'
root        = '/dev/xvda2 ro'
disk        = [
                  'phy:/dev/vg0/charmander.chakraos.org-disk,xvda2,w',
                  'phy:/dev/vg0/charmander.chakraos.org-swap,xvda1,w',
              ]
name        = 'charmander.chakraos.org'
vif         = [ 'ip=5.175.233.118 ,mac=00:11:22:33:44:55,bridge=br0' ]
on_poweroff = 'destroy'
on_reboot   = 'restart'
on_crash    = 'restart'</pre>
    <h3>Firewall</h3>
    <p>Incoming: All denied save for SSH access from rattata.</p>
    <p>Outgoing: All allowed.</p>
    <h3>Sites</h3>
    <ul>
        <li><strong>bugtracker</strong> Flyspray (/srv/www/chakraos.org/bugtracker)</li>
        <li><strong>ccr</strong> CCR (/srv/www/chakraos.org/ccr)</li>
        <li><strong>forum</strong> FluxBB (/srv/www/chakraos.org/forum)</li>
        <li><strong>home</strong> static pages (/srv/www/chakraos.org/home)</li>
        <li><strong>news</strong> Serendipity (/srv/www/chakraos.org/news)</li>
        <li><strong>packages</strong> Packages (/srv/www/chakraos.org/packages)</li>
        <li><strong>wiki</strong> MediaWiki (/srv/www/chakraos.org/wiki)</li>
    </ul>
    <h3>Services</h3>
    <ul>
        <li>SSH</li>
        <li>HTTP</li>
    </ul>
    <h3>Important configuration files</h3>
    <ul>
        <li>/etc/ssh/sshd_config</li>
        <li>/etc/network/interfaces</li>
        <li>/etc/sysctl.conf</li>
        <li>/etc/pam.d/common-password</li>
        <li>/etc/login.defs</li>
        <li>/etc/skel/.ssh/authorized_keys</li>
        <li>/etc/hosts.allow</li>
        <li>/etc/hosts.deny</li>
        <li>/etc/rsyslog.conf</li>
        <li>/etc/nginx/nginx.conf</li>
        <li>/etc/nginx/sites-available/chakraos.org</li>
        <li>/etc/php?</li>
        <li></li>
    </ul>
    <h3>Important log files</h3>
    <ul>
        <li>/var/log/auth.log</li>
        <li>/var/log/ufw.log</li>
        <li>/var/log/syslog</li>
        <li></li>
    </ul>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>UID</th>
            <th>User</th>
            <th>Groups</th>
            <th>Key</th>
            <th>Role</th>
            <th>Cronjobs</th>
            <th>Owned directories</th>
        </tr>
        <tr>
            <td></td>
            <td>totte</td>
            <td>sudo</td>
            <td>Yes</td>
            <td>Administrator</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>inkane</td>
            <td>sudo</td>
            <td>Yes</td>
            <td>Administrator (backup)</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <hr />
    <a name="squirtle"><h2>squirtle <small>e-mail server</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>squirtle.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>mail.chakraos.org, lists.chakraos.org</dd>
        <dt>rDNS set</dt><dd>Yes</dd>
        <dt>IP</dt><dd>5.175.233.119</dd>
        <dt>Processor cores</dt><dd>1 (virtual)</dd>
        <dt>Memory</dt><dd>1 GB</dd>
        <dt>Disk: swap</dt><dd>4 GB</dd>
        <dt>Disk: /</dt><dd>32 GB</dd>
        <dt>Disk: /home</dt><dd>N/A</dd>
    </dl>
    <p>The second PV guest, it runs exim, dovecot, spamassassin, clamav and amavis to provide e-mail services.</p>
    <pre class="pre-scrollable">bootloader = '/usr/lib/xen-4.1/bin/pygrub'
cpus        = '4-7'
vcpus       = '1'
memory      = '1024'
root        = '/dev/xvda2 ro'
disk        = [
                  'phy:/dev/vg0/squirtle.chakraos.org-disk,xvda2,w',
                  'phy:/dev/vg0/squirtle.chakraos.org-swap,xvda1,w',
              ]
name        = 'squirtle.chakraos.org'
vif         = [ 'ip=5.175.233.119 ,mac=00:11:22:33:44:55,bridge=br0' ]
on_poweroff = 'destroy'
on_reboot   = 'restart'
on_crash    = 'restart'</pre>
    <h3>Firewall</h3>
    <p>Incoming: All denied save for SSH from rattata, SMTP and IMAP access from anywhere.</p>
    <p>Outgoing: All allowed.</p>
    <h3>Services</h3>
    <ul>
        <li>SSH</li>
        <li>SMTP</li>
        <li>IMAP</li>
    </ul>
    <h3>Important configuration files</h3>
    <ul>
        <li>/etc/ssh/sshd_config</li>
        <li>/etc/network/interfaces</li>
        <li>/etc/sysctl.conf</li>
        <li>/etc/pam.d/common-password</li>
        <li>/etc/login.defs</li>
        <li>/etc/skel/.ssh/authorized_keys</li>
        <li>/etc/hosts.allow</li>
        <li>/etc/hosts.deny</li>
        <li>/etc/rsyslog.conf</li>
    </ul>
    <h3>Important log files</h3>
    <ul>
        <li>/var/log/auth.log</li>
        <li>/var/log/ufw.log</li>
        <li>/var/log/syslog</li>
        <li></li>
    </ul>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>UID</th>
            <th>User</th>
            <th>Groups</th>
            <th>Key</th>
            <th>Role</th>
            <th>Cronjobs</th>
            <th>Owned directories</th>
        </tr>
        <tr>
            <td></td>
            <td>totte</td>
            <td>sudo</td>
            <td>Yes</td>
            <td>Administrator</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <hr />
    <a name="pidgey"><h2>pidgey <small>database server</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>pidgey.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>N/A</dd>
        <dt>rDNS set</dt><dd>Yes</dd>
        <dt>IP</dt><dd>5.175.233.120</dd>
        <dt>Processor cores</dt><dd>1 (virtual)</dd>
        <dt>Memory</dt><dd>2 GB</dd>
        <dt>Disk: swap</dt><dd>4 GB</dd>
        <dt>Disk: /</dt><dd>32 GB</dd>
        <dt>Disk: /home</dt><dd>N/A</dd>
    </dl>
    <p>The third PV guest, it runs PostgreSQL.</p>
    <pre class="pre-scrollable">bootloader = '/usr/lib/xen-4.1/bin/pygrub'
cpus        = '4-7'
vcpus       = '1'
memory      = '2048'
root        = '/dev/xvda2 ro'
disk        = [
                  'phy:/dev/vg0/pidgey.chakraos.org-disk,xvda2,w',
                  'phy:/dev/vg0/pidgey.chakraos.org-swap,xvda1,w',
              ]
name        = 'pidgey.chakraos.org'
vif         = [ 'ip=5.175.233.120 ,mac=00:11:22:33:44:55,bridge=br0' ]
on_poweroff = 'destroy'
on_reboot   = 'restart'
on_crash    = 'restart'</pre>
    <h3>Firewall</h3>
    <p>Incoming: All denied save for SSH rattata, RDBMS access from charmander and squirtle.</p>
    <p>Outgoing: All allowed.</p>
    <h3>Services</h3>
    <ul>
        <li>SSH</li>
        <li>PostgreSQL</li>
    </ul>
    <h3>Important configuration files</h3>
    <ul>
        <li>/etc/ssh/sshd_config</li>
        <li>/etc/network/interfaces</li>
        <li>/etc/sysctl.conf</li>
        <li>/etc/pam.d/common-password</li>
        <li>/etc/login.defs</li>
        <li>/etc/skel/.ssh/authorized_keys</li>
        <li>/etc/hosts.allow</li>
        <li>/etc/hosts.deny</li>
        <li>/etc/rsyslog.conf</li>
    </ul>
    <h3>Important log files</h3>
    <ul>
        <li>/var/log/auth.log</li>
        <li>/var/log/ufw.log</li>
        <li>/var/log/syslog</li>
        <li></li>
    </ul>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>UID</th>
            <th>User</th>
            <th>Groups</th>
            <th>Key</th>
            <th>Role</th>
            <th>Cronjobs</th>
            <th>Owned directories</th>
        </tr>
        <tr>
            <td></td>
            <td>totte</td>
            <td>sudo</td>
            <td>Yes</td>
            <td>Administrator</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <hr />
    <a name="rattata"><h2>rattata <small>file server</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>rattata.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>rsync.chakraos.org</dd>
        <dt>rDNS set</dt><dd>Yes</dd>
        <dt>IP</dt><dd>5.175.233.121</dd>
        <dt>Processor cores</dt><dd>1 (virtual)</dd>
        <dt>Memory</dt><dd>2 GB</dd>
        <dt>Disk: swap</dt><dd>4 GB</dd>
        <dt>Disk: /</dt><dd>256 GB</dd>
        <dt>Disk: /home</dt><dd>N/A</dd>
    </dl>
    <p>The fourth PV guest, it runs rsyncd and nginx to serve the package repositories. All packagers have access to this machine.</p>
    <pre class="pre-scrollable">bootloader = '/usr/lib/xen-4.1/bin/pygrub'
cpus        = '4-7'
vcpus       = '1'
memory      = '2048'
root        = '/dev/xvda2 ro'
disk        = [
                  'phy:/dev/vg0/rattata.chakraos.org-disk,xvda2,w',
                  'phy:/dev/vg0/rattata.chakraos.org-swap,xvda1,w',
              ]
name        = 'rattata.chakraos.org'
vif         = [ 'ip=5.175.233.121 ,mac=00:11:22:33:44:55,bridge=br0' ]
on_poweroff = 'destroy'
on_reboot   = 'restart'
on_crash    = 'restart'</pre>
    <p>User passwords policy:</p>
    <ul>
        <li>Passwords expire every 64 days</li>
        <li>A warning will be sent out 8 days in advance</li>
        <li>The previous 12 passwords may not be reused</li>
        <li>Password requirements:
            <ul>
                <li>minlen=16 (minimum length is 16 characters)</li>
                <li>difok=8 (minimum difference from old password is 8 characters)</li>
                <li>ucredit=-2 (at least 2 upper case letters)</li>
                <li>lcredit=-2 (at least 2 lower case letters)</li>
                <li>dcredit=-2 (at least 2 digits)</li>
                <li>ocredit=-2 (at least 2 symbols)</li>
            </ul>
        </li>
    </ul>
    <h3>Firewall</h3>
    <p>Incoming: All denied save for SSH, HTTP and rsync (read only) access from anywhere.</p>
    <p>Outgoing: All allowed.</p>
    <h3>Sites</h3>
    <ul>
        <li><strong>packages</strong> (/srv/www/packages)</li>
    </ul>
    <h3>Services</h3>
    <ul>
        <li>SSH</li>
        <li>rsync</li>
        <li>git</li>
        <li>HTTP</li>
    </ul>
    <h3>Important configuration files</h3>
    <ul>
        <li>/etc/ssh/sshd_config</li>
        <li>/etc/network/interfaces</li>
        <li>/etc/sysctl.conf</li>
        <li>/etc/pam.d/common-password</li>
        <li>/etc/login.defs</li>
        <li>/etc/skel/.ssh/authorized_keys</li>
        <li>/etc/hosts.allow</li>
        <li>/etc/hosts.deny</li>
        <li>/etc/rsyslog.conf</li>
        <li>/etc/nginx/nginx.conf</li>
        <li>/etc/nginx/sites-available/chakraos.org</li>
        <li>/etc/php?</li>
    </ul>
    <h3>Important log files</h3>
    <ul>
        <li>/var/log/auth.log</li>
        <li>/var/log/ufw.log</li>
        <li>/var/log/syslog</li>
        <li></li>
    </ul>
    <h3>Groups</h3>
    <dl class="dl-horizontal">
        <dt>sudo</dt><dd>root stuff: package management, configurations (use saltstack)</dd>
        <dt>staff</dt><dd>write access to /usr/local</dd>
        <dt>packagers-core</dt><dd>write access to core package repositories</dd>
        <dt>packagers-mantle</dt><dd>write access to mantle package repositories</dd>
        <dt>packagers-crust</dt><dd>write access to crust package repositories</dd>
        <dt>artists</dt><dd>write access to artwork directory</dd>
    </dl>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>UID</th>
            <th>User</th>
            <th>Groups</th>
            <th>Key</th>
            <th>Role</th>
            <th>Cronjobs</th>
            <th>Owned directories</th>
        </tr>
        <tr>
            <td></td>
            <td>totte</td>
            <td>sudo, packagers-mantle, packagers-crust</td>
            <td>Yes</td>
            <td>Administrator</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>boom1992</td>
            <td>developers-akabei</td>
            <td>No</td>
            <td>Developer</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>tetris4</td>
            <td>staff, packagers-core, packagers-mantle, packagers-crust</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>inkane</td>
            <td>sudo, staff, packagers-core, packagers-mantle, packagers-crust, developers-web, developers-tribe</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>almack</td>
            <td>sudo, staff, packagers-core, packagers-mantle, packagers-crust, developers-web, developers-kinky, developers-tribe, artists</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>gallaecio</td>
            <td>packagers-mantle, packagers-crust</td>
            <td>No</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>george2</td>
            <td>packagers-crust, developers-web, developers-kapudan</td>
            <td>Yes</td>
            <td>Developer</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>gcala</td>
            <td>packagers-mantle, packagers-crust</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>csslayer</td>
            <td>packagers-mantle, packagers-crust</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>brli</td>
            <td>packagers-crust</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>franzmari</td>
            <td>packagers-mantle, packagers-crust</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>ram-z</td>
            <td>sudo, staff, packagers-core, packagers-mantle, packagers-crust, developers-web, developers-tribe, developers-ccr-tools</td>
            <td>Yes</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>pyrdracon</td>
            <td>packagers-crust</td>
            <td>No</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>utg</td>
            <td>packagers-crust</td>
            <td>No</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>s8321414</td>
            <td>packagers-crust</td>
            <td>No</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td>djustice</td>
            <td>packagers-crust</td>
            <td>No</td>
            <td>Packager</td>
            <td></td>
            <td></td>
        </tr>
    </table>
    <h3>Package repositories</h3>
    <ul>
        <li>ssh://rattata.chakraos.org:/srv/www/packages</li>
        <li>http://rattata.chakraos.org</li>
        <li>rsync://rattata.chakraos.org::packages</li>
    </ul>
    <p>rsyncd is limited to 10 connections, mirror providers may apply for official status and gain priority access.</p>
    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th>Group</th>
        </tr>
        <tr>
            <td>apps</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>bundles</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>core</td>
            <td>packagers-core</td>
        </tr>
        <tr>
            <td>desktop</td>
            <td>packagers-mantle</td>
        </tr>
        <tr>
            <td>extra</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>games</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>kde-next</td>
            <td>packagers-mantle</td>
        </tr>
        <tr>
            <td>kde-staging</td>
            <td>packagers-mantle</td>
        </tr>
        <tr>
            <td>kde-unstable</td>
            <td>packagers-mantle</td>
        </tr>
        <tr>
            <td>lib32</td>
            <td>packagers-mantle</td>
        </tr>
        <tr>
            <td>platform</td>
            <td>packagers-mantle</td>
        </tr>
        <tr>
            <td>staging</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>testing</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>unstable</td>
            <td>packagers-crust</td>
        </tr>
    </table>
    <hr />
    <a name="snorlax"><h2>snorlax <small>backup server</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>Unknown</dd>
        <dt>DNS aliases</dt><dd>N/A</dd>
        <dt>rDNS set</dt><dd>Unknown</dd>
        <dt>IP</dt><dd>Unknown</dd>
    </dl>
    <p>Placeholder text.</p>
    <hr />
    <a name="abra"><h2>abra <small>log server</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>abra.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>stats.chakraos.org</dd>
        <dt>rDNS set</dt><dd>Unknown</dd>
        <dt>IP</dt><dd>168.235.151.91</dd>
    </dl>
    <p>Placeholder text.</p>
    <hr />
    <a name="eevee"><h2>eevee <small>build server</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>Unknown</dd>
        <dt>DNS aliases</dt><dd>N/A</dd>
        <dt>rDNS set</dt><dd>Unknown</dd>
        <dt>IP</dt><dd>Unknown</dd>
    </dl>
    <p>Placeholder text.</p>
    <hr />
    <a name="sandshrew"><h2>sandshrew <small>community server (Italian)</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>sandshrew.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>N/A</dd>
        <dt>rDNS set</dt><dd>Yes</dd>
        <dt>IP</dt><dd>5.175.234.180</dd>
    </dl>
    <p>Placeholder text.</p>
    <hr />
    <a name="oddish"><h2>oddish <small>community server (Spanish)</small></h2></a>
    <dl class="dl-horizontal">
        <dt>FQDN</dt><dd>oddish.chakraos.org</dd>
        <dt>DNS aliases</dt><dd>N/A</dd>
        <dt>rDNS set</dt><dd>Yes</dd>
        <dt>IP</dt><dd>5.175.233.138</dd>
    </dl>
    <p>Placeholder text.</p>
    <hr />
    <a name="news"><h2>News <small>web application</small></h2></a>
    <dl class="dl-horizontal">
        <dt>URL</dt><dd>chakraos.org/news</dd>
        <dt>Type</dt><dd>Blog</dd>
        <dt>Software</dt><dd>Serendipity</dd>
    </dl>
    <p>Lorem ipsum dolor sit amet.</p>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>User</th>
            <th>Groups</th>
        </tr>
        <tr>
            <td>totte</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>tetris4</td>
            <td>Editor</td>
        </tr>
        <tr>
            <td>inkane</td>
            <td>Editor</td>
        </tr>
    </table>
    <hr />
    <a name="forum"><h2>Forum <small>web application</small></h2></a>
    <dl class="dl-horizontal">
        <dt>URL</dt><dd>chakraos.org/forum</dd>
        <dt>Type</dt><dd>Forum</dd>
        <dt>Software</dt><dd>FluxBB</dd>
    </dl>
    <p>Lorem ipsum dolor sit amet.</p>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>User</th>
            <th>Groups</th>
            <th>Role</th>
        </tr>
        <tr>
            <td>totte</td>
            <td>Administrator</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>tetris4</td>
            <td>Administrator</td>
            <td>Communicator</td>
        </tr>
        <tr>
            <td>inkane</td>
            <td>Administrator</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>almack</td>
            <td>Administrator</td>
            <td>Packager</td>
        </tr>
        <tr>
            <td>brli</td>
            <td>Administrator</td>
            <td>Packager</td>
        </tr>
        <tr>
            <td>boom1992</td>
            <td>Administrator</td>
            <td>Developer</td>
        </tr>
        <tr>
            <td>ram-z</td>
            <td>Administrator</td>
            <td>"Chakra Pony"</td>
        </tr>
        <tr>
            <td>gallaecio</td>
            <td>Moderator</td>
            <td>Packager</td>
        </tr>
        <tr>
            <td>gcala</td>
            <td>Moderator</td>
            <td>Packager</td>
        </tr>
        <tr>
            <td>pyrdracon</td>
            <td>Moderator</td>
            <td>Packager</td>
        </tr>
    </table>
    <hr />
    <a name="wiki"><h2>Wiki <small>web application</small></h2></a>
    <dl class="dl-horizontal">
        <dt>URL</dt><dd>chakraos.org/wiki</dd>
        <dt>Type</dt><dd>Wiki</dd>
        <dt>Software</dt><dd>MediaWiki</dd>
    </dl>
    <p>Lorem ipsum dolor sit amet.</p>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>User</th>
            <th>Groups</th>
        </tr>
        <tr>
            <td>totte</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>almack</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>boom1992</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>gallaecio</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>csslayer</td>
            <td>Bureaucrat</td>
        </tr>
        <tr>
            <td>ram-z</td>
            <td>Bureaucrat</td>
        </tr>
    </table>
    <hr />
    <a name="ccr"><h2>CCR <small>web application</small></h2></a>
    <dl class="dl-horizontal">
        <dt>URL</dt><dd>chakraos.org/ccr</dd>
        <dt>Type</dt><dd>User package repository</dd>
        <dt>Software</dt><dd>CCR (AUR fork)</dd>
    </dl>
    <p>Lorem ipsum dolor sit amet.</p>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>User</th>
            <th>Groups</th>
        </tr>
        <tr>
            <td>totte</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>ram-z</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>inkane</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>george</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>gallaecio</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>almack</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>danyf90</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>enoop</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>franzmari</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>gcala</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>pyrdracon</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>tetris4</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>utg</td>
            <td>Moderator</td>
        </tr>
    </table>
    <hr />
    <a name="bugtracker"><h2>Bugtracker <small>web application</small></h2></a>
    <dl class="dl-horizontal">
        <dt>URL</dt><dd>chakraos.org/bugtracker</dd>
        <dt>Type</dt><dd>Bug tracking</dd>
        <dt>Software</dt><dd>Flyspray</dd>
    </dl>
    <p>Lorem ipsum dolor sit amet.</p>
    <h3>Users (all projects)</h3>
    <table class="table table-striped">
        <tr>
            <th>User</th>
            <th>Groups</th>
        </tr>
        <tr>
            <td>totte</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>inkane</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>tetris4</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>almack</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>ram-z</td>
            <td>Moderator</td>
        </tr>
        <tr>
            <td>boom1992</td>
            <td>Contributor</td>
        </tr>
        <tr>
            <td>brli</td>
            <td>Contributor</td>
        </tr>
        <tr>
            <td>franzmari</td>
            <td>Contributor</td>
        </tr>
        <tr>
            <td>george</td>
            <td>Contributor</td>
        </tr>
        <tr>
            <td>pyrdracon</td>
            <td>Contributor</td>
        </tr>
        <tr>
            <td>s8321414</td>
            <td>Contributor</td>
        </tr>
        <tr>
            <td>utg</td>
            <td>Contributor</td>
        </tr>
    </table>
    <hr />
    <a name="reviewboard"><h2>Review Board <small>web application</small></h2></a>
    <dl class="dl-horizontal">
        <dt>URL</dt><dd>chakraos.org/reviewboard</dd>
        <dt>Type</dt><dd>Code review</dd>
        <dt>Software</dt><dd>Review Board</dd>
    </dl>
    <p>Lorem ipsum dolor sit amet.</p>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>User</th>
            <th>Groups</th>
        </tr>
        <tr>
            <td>totte</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>inkane</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>almack</td>
            <td>Administrator</td>
        </tr>
        <tr>
            <td>boom1992</td>
            <td>Administrator</td>
        </tr>
    </table>
    <hr />
    <a name="git"><h2>Git, Gitolite & GitWeb <small>VCS, ACL and web application</small></h2></a>
    <dl class="dl-horizontal">
        <dt>URL</dt><dd>git.chakraos.org</dd>
        <dt>Type</dt><dd>Version control, access control layer, web application</dd>
        <dt>Software</dt><dd>Git, Gitolite & GitWeb</dd>
    </dl>
    <p>Lorem ipsum dolor sit amet.</p>
    <h3>Users</h3>
    <table class="table table-striped">
        <tr>
            <th>User</th>
            <th>Groups</th>
        </tr>
        <tr>
            <td>totte</td>
            <td>administrators, developers, packagers-core, packagers-mantle, packagers-crust</td>
        </tr>
        <tr>
            <td>inkane</td>
            <td>developers, packagers-core, packagers-mantle, packagers-crust</td>
        </tr>
        <tr>
            <td>boom1992</td>
            <td>developers</td>
        </tr>
        <tr>
            <td>almack</td>
            <td>developers, packagers-core, packagers-mantle, packagers-crust</td>
        </tr>
        <tr>
            <td>ram-z</td>
            <td>developers, packagers-core, packagers-mantle, packagers-crust</td>
        </tr>
        <tr>
            <td>george2</td>
            <td>developers, packagers-crust</td>
        </tr>
        <tr>
            <td>tetris4</td>
            <td>packagers-core, packagers-mantle, packagers-crust</td>
        </tr>
        <tr>
            <td>csslayer</td>
            <td>packagers-mantle, packagers-crust</td>
        </tr>
        <tr>
            <td>gcala</td>
            <td>packagers-mantle, packagers-crust</td>
        </tr>
        <tr>
            <td>brli</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>franzmari</td>
            <td>packagers-crust</td>
        </tr>
        <tr>
            <td>utg</td>
            <td>packagers-crust</td>
        </tr>
    </table>
</div>
