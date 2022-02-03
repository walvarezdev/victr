# VICTR Candidate Assessment Github PHP

# Description

   Tech Stack: Codeigniter 4, mysql, jquery (plugins), boostrap 

   Update .env with baseURL and MySql credentials 

   Required: "writable" folder with 777 security access 
   
   Note: I do not commit the .env but this case is an exception.

#  mysql script

<pre>
CREATE TABLE `repository` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_push_date` datetime DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `status` int(3) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
</pre>

# To test app

<pre>
    >php spark serve 
</pre>