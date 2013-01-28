TestJobForm
===========
1. The form must be completed manner understandable to the user, provide the necessary instructions, comments, etc. (usability).
2. The form must have the ability to add different interface languages.
3. The script should include means of verification and validation of fields, as well as protection from incorrect data entry, special characters, hacking attempts, etc.
4. Validation and verification of the fields must be performed on both the client side (by means of JavaScript), and on the server side (by means of php).
5. The database structure should be reasonable.
6. In addition to the introduction of text data in a user registration must be able to upload a graphic file formats gif, jpg, png.
7. Help text in the form (labels, hints, errors, etc.) should be properly formulated and understood by humans, sustained business style and respectful treatment.
8. Code must be written clearly and accurately in compliance with tabs and other elements of writing, no extra features and functions that are not related to the functional test task, provided with clear comments.
9. We draw attention to the fact that is it not only the technical part of the executed task (codes), but also design (appearance, logic design, the completeness of the instructions).

Note: The use of scripts and frameworks are not allowed.

The time during which the test job done ~16 Hours

1. Decided not to use the pattern MVC, for the sake of a single file
2. Form easily extensible, easy to add new types of fields and validators
3. In the form, you can add filters as validators
4. Check javascript dynamically depending on the attributes
5. Get things looked added Twitter Bootstrap
<!--
mysqldump -utest_form -p#8fGmAHV#8fGmAHV -B test_form > database.sql
mysql --user=test_form test_form -p#8fGmAHV#8fGmAHV

GRANT ALL PRIVILEGES ON  `test_form` . * TO  'test_form'@'localhost' IDENTIFIED BY  '#8fGmAHV#8fGmAHV' WITH GRANT OPTION ;
CREATE TABLE IF NOT EXISTS `test_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;
-->