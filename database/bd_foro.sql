-- Creacion de la base de datos
create database bd_foro;
use bd_foro;

-- Creacion de la tabla rol
create table tbl_rol(
    id_rol int auto_increment primary key,
    nombre_rol varchar(50) not null
);

-- Creacion de la tabla usuario
create table tbl_usuarios(
    id_usu int auto_increment primary key,
    username_usu varchar(50) not null,
    nombre_real varchar(50) not null,
    email_usu varchar(100) not null,
    password_usu varchar(255) not null,
    fecha_alta_usu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_rol int not null
);

-- Creacion de la tabla preguntas
create table tbl_preguntas(
    id_preg int auto_increment primary key,
    titulo_preg varchar(100) not null,
    descripcion_preg varchar(255) not null,
    fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usu int not null
);

-- Creacion de la tabla respuestas
create table tbl_respuestas(
    id_resp int auto_increment primary key,
    contenido_resp varchar(500) not null,
    fecha_resp_usu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_preg int not null,
    id_usu int not null
);

-- Creacion de la tabla solicitud de amistad
create table tbl_solicitud(
    id_soli int auto_increment primary key,
    estado_soli enum('pendiente','aceptado','rechazado') DEFAULT 'pendiente',
    fecha_soli TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario_uno int not null,
    id_usuario_dos int not null
);

-- Creacion de la tabla mensajes
create table tbl_mensaje(
    id_men int auto_increment primary key,
    contenido_men varchar(255) not null,
    fecha_men TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario_remitente int not null,
    id_usuario_destinatario int not null
);

-- Foreign key de tbl_rol a tbl_usuario
alter table tbl_usuarios
    add constraint fk_rol_usuario foreign key (id_rol) references tbl_rol(id_rol);

-- Foreign key de tbl_preguntas a tbl_usuarios
alter table tbl_preguntas
    add constraint fk_pregunta_usuario foreign key (id_usu) references tbl_usuarios(id_usu);

-- Foreign key de tbl_respuestas a tbl_usuarios y tbl_preguntas
alter table tbl_respuestas
    add constraint fk_respuesta_usuario foreign key (id_usu) references tbl_usuarios(id_usu);

alter table tbl_respuestas
    add constraint fk_respuesta_pregunta foreign key (id_preg) references tbl_preguntas(id_preg);

-- Foreign key de tbl_solicitud a tbl_usuarios
alter table tbl_solicitud
    add constraint fk_solicitud_usuario_uno foreign key (id_usuario_uno) references tbl_usuarios(id_usu);

alter table tbl_solicitud
    add constraint fk_solicitud_usuario_dos foreign key (id_usuario_dos) references tbl_usuarios(id_usu);

-- Foreign key de tbl_mensaje a tbl_usuarios
alter table tbl_mensaje
    add constraint fk_mensaje_usuario_remitente foreign key (id_usuario_remitente) references tbl_usuarios(id_usu);

alter table tbl_mensaje
    add constraint fk_mensaje_usuario_destinatario foreign key (id_usuario_destinatario) references tbl_usuarios(id_usu);

-- Insert en tbl_rol
INSERT INTO tbl_rol (nombre_rol) VALUE ('usuario');