create table users(
  name VARCHAR(20) not null,
  lastName VARCHAR(20) not null,
  email VARCHAR(50) not null,
  password VARCHAR(60) not null,
  access ENUM('admin', 'user') DEFAULT 'user' not null,
  regDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP not null,
  CONSTRAINT pk_user PRIMARY KEY (email)
);

CREATE TABLE articles(
  idArticle int not null AUTO_INCREMENT,
  lang varchar(3) not null,
  author varchar(50) not null,
  title VARCHAR(80) not null,
  text TEXT not null,
  image VARCHAR(50) not null,
  date TIMESTAMP DEFAULT current_timestamp not null,
  CONSTRAINT pk_article PRIMARY KEY (idArticle, lang),
  CONSTRAINT fk_author FOREIGN KEY (author) REFERENCES users(email),
  CONSTRAINT uk_title UNIQUE KEY (title)
);

CREATE TABLE galleries(
  idGallery int not null,
  name VARCHAR(30) not null,
  text text not null,
  date TIMESTAMP DEFAULT current_timestamp not null,
  CONSTRAINT pk_gallery PRIMARY KEY(idGallery),
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