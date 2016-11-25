# ContactMailer
![alt text](http://bolitec.org/logo/orange.jpg "bolitec_Logo")
## By bolitec.org
## Author: LF Bolivar
## Email: lfbolivar@bolitec.org
## Date: 4/1/2014
## This is the ContactMailer web application readme file


###Synopsis
This project initially set out to develop a procedural php application to store and organize contact information on the internet.  I am now looking to take parts of the code and apply in relevant places an Object Oriented Programming approach to enhance the functionality and configuration and potentially modularize to integrate into WordPress as a plug-in.  
The first thing to know about this application is that it utilizes database session support.  In order to run it under normal sessions you need to disable the sessionConfig.php. The second point affecting the installation of this app is that the database scripts all reside outside the public_html path. The scripts mentioned above reside in the secure folder of the project structure.