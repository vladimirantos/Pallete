create table users(
  name VARCHAR(20) not null,
  lastName VARCHAR(20) not null,
  email VARCHAR(50) not null,
  password VARCHAR(60) not null,
  access ENUM('admin', 'user') DEFAULT 'user' not null,
  regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP not null,
  CONSTRAINT pk_user PRIMARY KEY (email)
);

CREATE TABLE IF NOT EXISTS `offers` (
  `idOffer` int(11) NOT NULL,
  `lang` varchar(3) COLLATE utf8_czech_ci NOT NULL,
  `title` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `image` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

ALTER TABLE `offers`
  ADD PRIMARY KEY (`idOffer`,`lang`) USING BTREE;

ALTER TABLE `offers`
  MODIFY `idOffer` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;

CREATE TABLE articles(
  idArticle int not null AUTO_INCREMENT,
  lang varchar(3) not null,
  author varchar(50) not null,
  title VARCHAR(80) not null,
  text TEXT not null,
  image VARCHAR(50) not null,
  keywords varchar(255) not null,
  description varchar(255) not null,
  date TIMESTAMP DEFAULT current_timestamp not null,
  CONSTRAINT pk_article PRIMARY KEY (idArticle, lang),
  CONSTRAINT fk_author FOREIGN KEY (author) REFERENCES users(email),
  CONSTRAINT uk_title UNIQUE KEY (title)
);

CREATE TABLE galleries(
  idGallery varchar(13) not null,
  lang varchar(3) not null,
  name VARCHAR(30) not null,
  text text not null,
  date TIMESTAMP DEFAULT current_timestamp not null,
  CONSTRAINT pk_gallery PRIMARY KEY(idGallery, lang),
  CONSTRAINT uk_name UNIQUE KEY (name)
);

create table signlog(
  id int AUTO_INCREMENT PRIMARY KEY,
  user varchar(50) not null,
  ip BIGINT not null,
  date TIMESTAMP DEFAULT current_timestamp not null,
  FOREIGN KEY (user) REFERENCES users(email) on DELETE CASCADE
);

INSERT INTO users (name, lastName, email, password, access)
VALUES ('Admin', 'Administrovič', 'admin@asterix.cz', '$2y$10$TTrgd9z4T4x7uVmHhjtEsOt.kUSW/nuihej7Ajkk70SNCAduBQbGG', 'admin');