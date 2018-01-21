# MPWAR VirtualMachine

This is the base machine to use at all master's subjects.

To run this machine:
```
git clone #repositoryName#
cd mpwarAnsible/vagrant
vagrant up
#make a coffee and wait some time... 
vagrant ssh 
```

## Important files and folders
- share/www/html :  here you can put php or html code. Then using the ip 192.168.33.50 in your browser you can run the code.
- VagrantFile : in this file you can change any configuration about virtual machine, ip, number of cpu, memory etc.
- Access to mysql `mysql -u root -p` password root


## What has this machine?
- Centos 7
- Php 7.1
- Mysql Community 5.6
- Composer
- Apache
- Open ports 80 443 and 22