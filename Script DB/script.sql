create database cinesbd;
use cinesbd;

CREATE TABLE usuarios (
			id_usuario int unsigned AUTO_INCREMENT,
			dni_usuario int unsigned,
			nombre_usuario varchar(50),
			apellido_usuario varchar(50),
			email_usuario varchar(50),
			password_usuario varchar(50),
			id_fb_usuario varchar (50),
			admin_usuario boolean,
			constraint pk_id_usuario  PRIMARY KEY (id_usuario),
			constraint unq_email_usuario UNIQUE (email_usuario)
			);
                        
create table cines (
			id_cine int unsigned auto_increment,
			nombre_cine varchar(50),
			domicilio_cine varchar(50),
			altura_cine int unsigned,
			hora_apertura time,
			hora_cierre time,
			valor_entrada float unsigned,
			capacidad int unsigned,
			constraint pk_id_cine primary key (id_cine),
			constraint unq_nombre unique (nombre_cine),
			constraint unq_domicilio unique (domicilio_cine, altura_cine)
			);
                    
create table salas (
			id_sala int unsigned auto_increment,
			nombre varchar(50),
			capacidad int unsigned,
			id_cine int unsigned not null,
			constraint pk_sala primary key (id_sala),
			constraint fk_sala_cine foreign key (id_cine) references cines(id_cine)
			);
			
create table peliculas (
			id int unsigned not null,
			poster varchar(50),
			adultos tinyint,
			descripcion varchar(200),
			fecha_estreno date, 
			titulo_original varchar(50),
			titulo varchar(50),
			idioma_original varchar(50),
			fondo varchar(50),
			popularidad double,
			cantidad_votos float,
			video tinyint,
			puntuacion double,
			constraint pk_peliculas primary key (id),
			constraint unq_id unique (id)
			);
                        
create table generos (
			id int unsigned not null,
			nombre varchar(50),
			constraint pk_generos primary key (id),
			constraint unq_id unique (id),
			constraint unq_nombre unique (nombre)
			);
                        
create table peliculaxgenero (
			id_pelicula int unsigned not null,
			id_genero int unsigned not null,
			constraint pk_peliculaxgenero primary key (id_pelicula, id_genero)
			);
                                
create table funciones (
			id_funcion int unsigned auto_increment,
            fecha date,
            horario_funcion time,
            id_sala int unsigned,
            id_pelicula int unsigned,
            duracion int unsigned,
            constraint pk_funciones primary key (id_funcion),
            constraint fk_funciones_sala foreign key (id_sala) references salas(id_sala),
            constraint fk_funciones_pelicula foreign key (id_pelicula) references peliculas(id),
            constraint unq_fecha_pelicula unique (fecha, id_pelicula)
            );
                        
