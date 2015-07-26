@@ -1,4 +1,26 @@
etk2014
=======

Sistema estandar de symfony2 para pruebas
:::::::::::::::::::::::::::::::::::Objetivos:::::::::::::::::::::::::::::::::::::

Hito 1 

    Crea una webpage que contenga

        Ambos son paginas libres para los usuarios
        Inicio Pagina con un quienes somos y noticias de la web  
        Proyectos Pagina con un newsfeed que se retroalimenta de la db
        Contacto, permite enviar mails  y tiene datos de contacto
        vinculacion con Facebook

    Sistema de admin

        Inicio con un menu de herramientas para subir nuevas noticias, datos de los proyectos
        Mensajes envio de mensajes a los distintos usuarios
        ABM de usuarios y baneo de los mismos

    Sistema de usuarios
    Inicio con datos del perfil y estadisticas
    modificar perfil


Dia 2:

    Crear Bundles
        Bundle de noticias: va a tener la pagina de inicio y controlador modelo vista de noticias
        Bundle d eproyectos idem pero en proyectos
        Bundle de usuarios con el login, y pagina con subpagina de usuarios (ver perfil y enviar mensajes)


app - etk

noticias: EtkNoticiasBundle
proyectos: EtkProyectosBundle
usuarios: EtkUsuariosBundle


Una vez creados los bundles generar las entidades

    entidad Usuarios:
            id
            nombre
            apellido
            email
            username
            password
            createdDate
            UntilBannedDate
            modifiedDate
            Role
            Group


    entidad Noticias
            id
            userId
            Nombre
            Descripcion
            Fecha
            FechaPublicacion
            Titulo
            Subtitulo
            Cuerpo
            createdDate

    entidad Noticias_comentario
            id
            noticiasId
            descripcion
            createdDate
            likes
            notlikes
            replyto

    entidad Proyectos
            id
            nombre
            fecha_comienzo
            status
            createdDate

    entidad Proyectos_comentario
            id
            proyectoId
            descripcion
            createdDate
            likes
            notlikes

                
	entidad Grupo
		    id
		    nombre
		    createdDate


relaciones

  usuarios.group -> grupo.id
  noticias.userId-> usuarios.id
  proyectos_comentario.proyectoId -> Proyecto.id


manejo de roles
		usuario comun user_role
		usuario admin user_admin

/***  ejemplo para pruebas ***/
CREATE TABLE accounts(
    account_id INT NOT NULL AUTO_INCREMENT,
    customer_id INT( 4 ) NOT NULL ,
    account_type ENUM( 'savings', 'credit' ) NOT NULL,
    balance FLOAT( 9 ) NOT NULL,
    PRIMARY KEY ( account_id ),
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
) ENGINE=INNODB;

/*** ********************** ***/

use etksample;
CREATE TABLE IF NOT EXISTS etksample.Usuarios(
  id INT NOT NULL AUTO_INCREMENT,
  nombre varchar(100),
  apellido varchar(100),
  email varchar(255),
  username varchar(20),
  password VARCHAR(255),
  createdDate datetime,
  unitBannedDate datetime,
  modifiedDate datetime,
  role varchar(20),
  user_group int,
  PRIMARY KEY ( id )
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS etksample.Grupo(
  id INT NOT NULL AUTO_INCREMENT,
  nombre varchar(100),
  createdDate datetime,
  permisos varchar(255),
  PRIMARY KEY ( id )
) ENGINE=INNODB;

ALTER TABLE etksample.Usuarios
ADD CONSTRAINT `FK_myKey` FOREIGN KEY (`user_group`)
REFERENCES `Grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS etksample.Noticias(
  id INT NOT NULL AUTO_INCREMENT,
  userId INT NOT NULL,
  nombre varchar(1000),
  descripcion varchar(2000),
  fecha datetime,
  fechaPublicacion datetime,
  titulo VARCHAR(1000),
  subtitulo VARCHAR(1000),
  cuerpo VARCHAR(5000),
  createdDate datetime,
  modifiedDate datetime,
  PRIMARY KEY ( id ),
  FOREIGN KEY (userId) REFERENCES usuarios(id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS etksample.Noticias_comentario(
  id INT NOT NULL AUTO_INCREMENT,
  noticiasId INT,
  descripcion VARCHAR(2000),
  createdDate datetime,
  likes int,
  notlikes int,
  replyTo int,
  PRIMARY KEY ( id ),
  FOREIGN KEY (noticiasId) REFERENCES Noticias(id)
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS etksample.Proyectos(
  id INT NOT NULL AUTO_INCREMENT,
  nombre varchar(1000),
  descripcion varchar(2000),
  fecha_comienzo datetime,
  status VARCHAR(200),
  createdDate datetime,
  modifiedDate datetime,
  PRIMARY KEY ( id )
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS etksample.Proyectos_comentario(
  id INT NOT NULL AUTO_INCREMENT,
  proyectoId INT,
  descripcion VARCHAR(2000),
  createdDate datetime,
  likes int,
  notlikes int,
  replyTo int,
  PRIMARY KEY ( id ),
  FOREIGN KEY (proyectoId) REFERENCES Proyectos(id)
) ENGINE=INNODB;
