DROP VIEW correo_admin;
DROP VIEW notificacion_fase1;
DROP VIEW vista_5_comentarios;
DROP VIEW vista_comentario;
DROP VIEW vista_publicacion;
DROP VIEW who_percepcionel;
DROP VIEW who_percepcionchivo;
DROP VIEW percepcionel_fase2;
DROP VIEW percepcionchivo_fase2;
DROP VIEW percepcionel_fase1;
DROP VIEW percepcionchivo_fase1;
DROP VIEW publicacion_fase2;
DROP VIEW comentario_fase2;
DROP VIEW comentario_fase1;
DROP VIEW vista_perfil;
DROP VIEW estado_fase1;
DROP VIEW perfil_fase1;
DROP VIEW vista_carrera;
DROP VIEW publicacion_fase1;

DROP TABLE comentario;
DROP TABLE percepcion;
DROP TABLE notificacion;
DROP TABLE publicacion;
DROP TABLE perfil;
DROP TABLE estado;
DROP TABLE carrera;
DROP TABLE correo;
DROP TABLE facultad;
DROP TABLE tipo_percepcion;
DROP TABLE tipo_publicacion;
DROP TABLE tipo_estado;
DROP TABLE img;
DROP TABLE estado_notificacion;
DROP TABLE tipo_notificacion;
DROP TABLE miembro;


CREATE TABLE miembro (
  idmiembro SERIAL   NOT NULL ,
  clave TEXT    ,
  fecha_registro DATE    ,
  hora TIME      ,
PRIMARY KEY(idmiembro));


CREATE TABLE tipo_notificacion (
  idtipo_notificacion SERIAL PRIMARY KEY  NOT NULL,
  notificacion_tipo TEXT NOT NULL
);

CREATE TABLE estado_notificacion (
  idestado_notificacion SERIAL PRIMARY KEY  NOT NULL,
  notificacion_estado TEXT NOT NULL
);


CREATE TABLE img (
  idimg SERIAL   NOT NULL ,
  ruta TEXT      ,
PRIMARY KEY(idimg));




CREATE TABLE tipo_estado (
  idtipo_estado SERIAL   NOT NULL ,
  tipo_estado TEXT      ,
PRIMARY KEY(idtipo_estado));




CREATE TABLE tipo_publicacion (
  idtipo_publicacion SERIAL   NOT NULL ,
  tipo_publicacion TEXT      ,
PRIMARY KEY(idtipo_publicacion));




CREATE TABLE tipo_percepcion (
  idtipo_percepcion SERIAL   NOT NULL ,
  tipo TEXT      ,
PRIMARY KEY(idtipo_percepcion));




CREATE TABLE facultad (
  idfacultad SERIAL   NOT NULL ,
  facultad TEXT      ,
PRIMARY KEY(idfacultad));



CREATE TABLE correo (
  idcorreo SERIAL   NOT NULL ,
  miembro_idmiembro INTEGER   NOT NULL ,
  correo TEXT      ,
PRIMARY KEY(idcorreo, miembro_idmiembro)  ,
  FOREIGN KEY(miembro_idmiembro)
    REFERENCES miembro(idmiembro));


CREATE INDEX correo_FKIndex1 ON correo (miembro_idmiembro);


CREATE INDEX IFK_Rel_01 ON correo (miembro_idmiembro);


CREATE TABLE carrera (
  idcarrera SERIAL   NOT NULL ,
  facultad_idfacultad INTEGER   NOT NULL ,
  carrera TEXT      ,
PRIMARY KEY(idcarrera, facultad_idfacultad)  ,
  FOREIGN KEY(facultad_idfacultad)
    REFERENCES facultad(idfacultad));


CREATE INDEX carrera_FKIndex1 ON carrera (facultad_idfacultad);


CREATE INDEX IFK_Rel_18 ON carrera (facultad_idfacultad);


CREATE TABLE estado (
  idestado SERIAL   NOT NULL ,
  miembro_idmiembro INTEGER   NOT NULL ,
  tipo_estado_idtipo_estado INTEGER   NOT NULL ,
  fecha_estado DATE      ,
PRIMARY KEY(idestado, miembro_idmiembro, tipo_estado_idtipo_estado)    ,
  FOREIGN KEY(miembro_idmiembro)
    REFERENCES miembro(idmiembro),
  FOREIGN KEY(tipo_estado_idtipo_estado)
    REFERENCES tipo_estado(idtipo_estado));


CREATE INDEX estado_FKIndex1 ON estado (miembro_idmiembro);
CREATE INDEX estado_FKIndex2 ON estado (tipo_estado_idtipo_estado);


CREATE INDEX IFK_Rel_02 ON estado (miembro_idmiembro);
CREATE INDEX IFK_Rel_03 ON estado (tipo_estado_idtipo_estado);


CREATE TABLE perfil (
  idperfil SERIAL   NOT NULL ,
  carrera_idcarrera INTEGER   NOT NULL ,
  carrera_facultad_idfacultad INTEGER   NOT NULL ,
  miembro_idmiembro INTEGER   NOT NULL ,
  nombre TEXT    ,
  apellido TEXT    ,
  natalicio DATE    ,
  domicilio TEXT    ,
  frase TEXT      ,
PRIMARY KEY(idperfil, carrera_idcarrera, carrera_facultad_idfacultad, miembro_idmiembro)    ,
  FOREIGN KEY(carrera_idcarrera, carrera_facultad_idfacultad)
    REFERENCES carrera(idcarrera, facultad_idfacultad),
  FOREIGN KEY(miembro_idmiembro)
    REFERENCES miembro(idmiembro));


CREATE INDEX perfil_FKIndex1 ON perfil (carrera_idcarrera, carrera_facultad_idfacultad);
CREATE INDEX perfil_FKIndex2 ON perfil (miembro_idmiembro);


CREATE INDEX IFK_Rel_10 ON perfil (carrera_idcarrera, carrera_facultad_idfacultad);
CREATE INDEX IFK_Rel_19 ON perfil (miembro_idmiembro);


CREATE TABLE publicacion (
  idpublicacion SERIAL   NOT NULL ,
  tipo_publicacion_idtipo_publicacion INTEGER   NOT NULL ,
  img_idimg INTEGER   NOT NULL ,
  miembro_idmiembro INTEGER   NOT NULL ,
  fecha DATE    ,
  hora TIME    ,
  titulo TEXT    ,
  texto_publicacion TEXT      ,
PRIMARY KEY(idpublicacion, tipo_publicacion_idtipo_publicacion, img_idimg, miembro_idmiembro),
  FOREIGN KEY(tipo_publicacion_idtipo_publicacion)
    REFERENCES tipo_publicacion(idtipo_publicacion),
  FOREIGN KEY(img_idimg)
    REFERENCES img(idimg),
  FOREIGN KEY(miembro_idmiembro)
    REFERENCES miembro(idmiembro));


CREATE INDEX publicacion_FKIndex2 ON publicacion (tipo_publicacion_idtipo_publicacion);
CREATE INDEX publicacion_FKIndex3 ON publicacion (img_idimg);
CREATE INDEX publicacion_FKIndex4 ON publicacion (miembro_idmiembro);


CREATE INDEX IFK_Rel_07 ON publicacion (tipo_publicacion_idtipo_publicacion);
CREATE INDEX IFK_Rel_08 ON publicacion (img_idimg);
CREATE INDEX IFK_Rel_05 ON publicacion (miembro_idmiembro);

CREATE TABLE notificacion (
  idnotificacion SERIAL PRIMARY KEY  NOT NULL ,
  tipo_notificacion_idtipo_notificacion INTEGER NOT NULL REFERENCES tipo_notificacion (idtipo_notificacion),
  estado_notificacion_idestado_notificacion INTEGER NOT NULL REFERENCES estado_notificacion (idestado_notificacion),
  miembro_idmiembro INTEGER NOT NULL REFERENCES miembro (idmiembro),
  publicacion_img_idimg INTEGER   NOT NULL ,
  publicacion_tipo_publicacion_idtipo_publicacion INTEGER NOT NULL,
  publicacion_miembro_idmiembro INTEGER   NOT NULL ,
  publicacion_idpublicacion INTEGER   NOT NULL ,  fecha_notificacion DATE    ,
  hora_notificacion TIME,
  FOREIGN KEY(publicacion_idpublicacion, publicacion_miembro_idmiembro, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_img_idimg)
  REFERENCES publicacion(idpublicacion, miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg) ON UPDATE CASCADE ON DELETE CASCADE
  );


CREATE TABLE percepcion (
  idpercepcion SERIAL   NOT NULL ,
  miembro_idmiembro INTEGER   NOT NULL ,
  tipo_percepcion_idtipo_percepcion INTEGER   NOT NULL,
  publicacion_miembro_idmiembro INTEGER   NOT NULL ,
  publicacion_idpublicacion INTEGER   NOT NULL ,
  publicacion_img_idimg INTEGER   NOT NULL ,
  publicacion_tipo_publicacion_idtipo_publicacion INTEGER   NOT NULL,
PRIMARY KEY(idpercepcion, miembro_idmiembro, tipo_percepcion_idtipo_percepcion, publicacion_miembro_idmiembro, publicacion_idpublicacion, publicacion_img_idimg, publicacion_tipo_publicacion_idtipo_publicacion)      ,
  FOREIGN KEY(tipo_percepcion_idtipo_percepcion)
    REFERENCES tipo_percepcion(idtipo_percepcion),
  FOREIGN KEY(publicacion_idpublicacion, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_img_idimg, publicacion_miembro_idmiembro)
    REFERENCES publicacion(idpublicacion, tipo_publicacion_idtipo_publicacion, img_idimg, miembro_idmiembro),
  FOREIGN KEY(miembro_idmiembro)
    REFERENCES miembro(idmiembro));


CREATE INDEX percepcion_FKIndex1 ON percepcion (tipo_percepcion_idtipo_percepcion);
CREATE INDEX percepcion_FKIndex2 ON percepcion (publicacion_idpublicacion, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_img_idimg, publicacion_miembro_idmiembro);
CREATE INDEX percepcion_FKIndex3 ON percepcion (miembro_idmiembro);


CREATE INDEX IFK_Rel_12 ON percepcion (tipo_percepcion_idtipo_percepcion);
CREATE INDEX IFK_Rel_17 ON percepcion (publicacion_idpublicacion, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_img_idimg, publicacion_miembro_idmiembro);
CREATE INDEX IFK_Rel_15 ON percepcion (miembro_idmiembro);


CREATE TABLE comentario (
  idcomentario SERIAL   NOT NULL ,
  miembro_idmiembro INTEGER   NOT NULL ,
  publicacion_img_idimg INTEGER   NOT NULL ,
  publicacion_tipo_publicacion_idtipo_publicacion INTEGER   ,
  publicacion_miembro_idmiembro INTEGER   NOT NULL ,
  publicacion_idpublicacion INTEGER   NOT NULL ,
  fecha DATE    ,
  hora TIME    ,
  texto TEXT    NOT NULL,
PRIMARY KEY(idcomentario, miembro_idmiembro, publicacion_img_idimg, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_miembro_idmiembro, publicacion_idpublicacion)    ,
  FOREIGN KEY(miembro_idmiembro)
    REFERENCES miembro(idmiembro),
  FOREIGN KEY(publicacion_idpublicacion, publicacion_miembro_idmiembro, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_img_idimg)
    REFERENCES publicacion(idpublicacion, miembro_idmiembro, tipo_publicacion_idtipo_publicacion, img_idimg) ON UPDATE CASCADE ON DELETE CASCADE
);


CREATE INDEX comentario_FKIndex1 ON comentario (miembro_idmiembro);
CREATE INDEX comentario_FKIndex2 ON comentario (publicacion_idpublicacion, publicacion_miembro_idmiembro, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_img_idimg);


CREATE INDEX IFK_Rel_04 ON comentario (miembro_idmiembro);
CREATE INDEX IFK_Rel_14 ON comentario (publicacion_idpublicacion, publicacion_miembro_idmiembro, publicacion_tipo_publicacion_idtipo_publicacion, publicacion_img_idimg);





----estado-notificacion---

INSERT INTO estado_notificacion (notificacion_estado)
VALUES  ('visto');

INSERT INTO estado_notificacion (notificacion_estado)
VALUES  ('sin_ver');



----tipo-notificacion---

INSERT INTO tipo_notificacion (notificacion_tipo)
VALUES  ('reportar publicacion');

INSERT INTO tipo_notificacion (notificacion_tipo)
VALUES  ('demanda a miembro');
----notificacion---

#INSERT INTO notificacion (tipo_notificacion_idtipo_notificacion, estado_notificacion_idestado_notificacion,
#                        miembro_idmiembro, fecha_notificacion, hora_notificacion)
#VALUES  ('');



----tipo-publi---

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('libre');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('evento');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('foro');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('comentario');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('portada');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('oculto');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('primera_portada');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('foto_perfil');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('primera_foto_perfil');

INSERT INTO tipo_publicacion (tipo_publicacion)
VALUES  ('no_publicada_foto_perfil');

-----tipo-estado----

INSERT INTO tipo_estado (tipo_estado)
VALUES  ('estudiando');

INSERT INTO tipo_estado (tipo_estado)
VALUES  ('egresado');

INSERT INTO tipo_estado (tipo_estado)
VALUES  ('administrador');


-----tipo-percepcion----

INSERT INTO tipo_percepcion (tipo)
VALUES  ('chivo');

INSERT INTO tipo_percepcion (tipo)
VALUES  ('nel');


-----facultad-----

INSERT INTO facultad (facultad)
VALUES  ('none');

INSERT INTO facultad (facultad)
VALUES  ('Ciencias del Hombre y la Naturaleza');

INSERT INTO facultad (facultad)
VALUES  ('Teología y Humanidades');

-----carrera------

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('1', 'ninguno');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('2', 'Licenciatura en Ciencias de la Computación');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('2', 'Licenciatura en Administración de Empresas');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('2', 'Licenciatura en Ciencias Jurídicas');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('2', 'Ingeniería Agroecológica');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('2', 'Licenciatura en Contaduría Pública');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('3', 'Licenciatura en Teología');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('3', 'Licenciatura en Ciencias de la Educación [Epecialidad en Parvularía]');

INSERT INTO carrera (facultad_idfacultad, carrera)
VALUES  ('3', 'Licenciatura en Trabajo Social');



---------img------------
INSERT INTO img (ruta)
VALUES  ('none');

INSERT INTO img (ruta)
VALUES  ('./recursos/default-portada.jpg');

INSERT INTO img (ruta)
VALUES  ('./recursos/default-user.png');




CREATE VIEW publicacion_fase1
AS SELECT
  d.idpublicacion,
  a.idmiembro as miembro,
  d.tipo_publicacion_idtipo_publicacion as idtipo_publi,
  b.tipo_publicacion as publicó,
  d.titulo as Titulo,
  d.img_idimg as idimagen,
  c.ruta as imagen,
  d.fecha,
  d.hora as tiempo,
  d.texto_publicacion
FROM
  miembro as a,
  tipo_publicacion as b,
  img as c,
  publicacion as d
WHERE
  idmiembro = miembro_idmiembro and
  idtipo_publicacion = tipo_publicacion_idtipo_publicacion and
  idimg = img_idimg;


CREATE VIEW vista_carrera
AS SELECT
idfacultad,
  facultad,
  carrera
FROM
  facultad,
  carrera
WHERE
  idfacultad = facultad_idfacultad;


CREATE VIEW perfil_fase1
AS SELECT
  idmiembro as n_miembro,
  nombre as Nombres,
  apellido as Apellidos,
  idcarrera as carreraid,
  carrera as "cursando carrera de",
  facultad as "de la facultad",
  natalicio as "nació el",
  domicilio as "vive en",
  frase as Frases
FROM
  miembro,
  perfil,
  carrera,
  facultad
WHERE
  idcarrera = carrera_idcarrera and
  idfacultad = carrera_facultad_idfacultad and
  idmiembro = miembro_idmiembro;


CREATE VIEW estado_fase1
AS SELECT
  idestado,
  miembro_idmiembro as Miembro,
  tipo_estado_idtipo_estado as idestado_tipo,
  tipo_estado as estado,
  fecha_estado as fecha
FROM
  estado,
  tipo_estado
WHERE
  idtipo_estado = tipo_estado_idtipo_estado;


CREATE VIEW vista_perfil
AS SELECT
  Miembro,
  (Nombres || ' ' || Apellidos) as nombres,
  idestado_tipo as tipo_estadoid,
  estado,
  fecha,
  "cursando carrera de",
  "de la facultad",
  "nació el",
  "vive en",
  Frases
FROM
  perfil_fase1,
  estado_fase1
WHERE
  n_miembro = Miembro;


CREATE VIEW comentario_fase1
AS SELECT
  c.idcomentario as idcoment,
  b.idmiembro as "Miembro comento",
  a.img_idimg as "en imagen",
  a.miembro_idmiembro as "dueño publicacion",
  a.idpublicacion as publicacion,
  c.fecha as "en fecha",
  c.hora as "en hora",
  c.texto as comentario
FROM
  comentario as c,
  miembro as b,
  publicacion as a
WHERE
  c.miembro_idmiembro = b.idmiembro and
  publicacion_img_idimg = img_idimg and
  c.publicacion_miembro_idmiembro = a.miembro_idmiembro and
  publicacion_idpublicacion = idpublicacion ;

CREATE VIEW comentario_fase2
AS SELECT
  "dueño publicacion",
  publicacion,
  count (comentario) as comentarios
FROM
  comentario_fase1
GROUP BY  "dueño publicacion", publicacion;


CREATE VIEW publicacion_fase2
AS SELECT
idpublicacion,
miembro,
Nombres,
Apellidos,
idtipo_publi,
publicó,
Titulo,
idimagen,
imagen,
fecha,
tiempo,
texto_publicacion
FROM
publicacion_fase1,
perfil_fase1
WHERE
miembro = n_miembro;



CREATE VIEW percepcionchivo_fase1
 AS SELECT
  miembro_idmiembro as miembro_persive,
  publicacion_miembro_idmiembro as dueño,
  publicacion_idpublicacion as numero_publicacion,
  tipo_percepcion_idtipo_percepcion as tipo_percep
FROM
  percepcion
WHERE
  tipo_percepcion_idtipo_percepcion = '1';


CREATE VIEW percepcionel_fase1
 AS SELECT
  miembro_idmiembro as miembro_persive,
  publicacion_miembro_idmiembro as dueño,
  publicacion_idpublicacion as numero_publicacion,
  tipo_percepcion_idtipo_percepcion as tipo_percep
FROM
  percepcion
WHERE
  tipo_percepcion_idtipo_percepcion = '2';


CREATE VIEW percepcionchivo_fase2
AS SELECT
  dueño,
  numero_publicacion,
  count (tipo_percep) as chivos
FROM
  percepcionchivo_fase1
GROUP BY  dueño, numero_publicacion;


CREATE VIEW percepcionel_fase2
AS SELECT
  dueño,
  numero_publicacion as number_publi,
  count (tipo_percep) as neles
FROM
  percepcionel_fase1
GROUP BY  dueño, numero_publicacion;

CREATE VIEW who_percepcionchivo
AS SELECT
  a.miembro_persive,
  nombres,
  numero_publicacion
FROM
  percepcionchivo_fase1 as a,
  vista_perfil as b,
  publicacion_fase1
WHERE
idpublicacion = numero_publicacion and
b.Miembro = a.miembro_persive;

CREATE VIEW who_percepcionel
AS SELECT
  a.miembro_persive,
  nombres,
  numero_publicacion
FROM
  percepcionel_fase1 as a,
  vista_perfil as b,
  publicacion_fase1
WHERE
idpublicacion = numero_publicacion and
b.Miembro = a.miembro_persive;

CREATE VIEW vista_publicacion
AS SELECT
idpublicacion,
miembro,
Nombres,
Apellidos,
idtipo_publi,
publicó,
Titulo,
idimagen,
imagen,
fecha,
tiempo,
texto_publicacion,
comentarios,
chivos,
neles
FROM
  publicacion_fase2
left join comentario_fase2
on publicacion = idpublicacion 
left join percepcionchivo_fase2
on numero_publicacion = idpublicacion
left join percepcionel_fase2
on number_publi = idpublicacion
GROUP BY 
idpublicacion,
miembro,
Nombres,
Apellidos,
idtipo_publi,
publicó,
Titulo,
idimagen,
imagen,
fecha,
tiempo,
texto_publicacion,
comentarios,
chivos,
neles;

CREATE VIEW vista_comentario
as select
  idcoment,
 "Miembro comento" as miembro_coment,
  a.nombres,
  imagen,
 "en imagen" as idimagen,
 "dueño publicacion" as dueño_publi,
 publicacion,
 "en fecha" as datefecha,
 "en hora" as datehora,
 "comentario" as coment
from
  comentario_fase1,
  vista_perfil as a,
  vista_publicacion
where
  "Miembro comento" = a.Miembro and
  publicacion = idpublicacion ;

CREATE VIEW vista_5_comentarios
as select * from vista_comentario 
order by datefecha desc, datehora desc;

select * from vista_5_comentarios where publicacion = 11 order by idcoment;

/*DROP VIEW notificacion_fase1;*/

CREATE VIEW notificacion_fase1
  AS SELECT
   a.idnotificacion as notificacion_id,
   a.publicacion_idpublicacion as publicacion_id,
   a.publicacion_img_idimg as img_id,
   a.publicacion_tipo_publicacion_idtipo_publicacion as tipopublicacion_id,
   a.tipo_notificacion_idtipo_notificacion as tiponotificacion_id,
   d.notificacion_tipo as tipo_notificacion,
   a.estado_notificacion_idestado_notificacion as estadonotificacion_id,
   fecha_notificacion as fecha,
   hora_notificacion as hora,
   a.publicacion_miembro_idmiembro as dueño_publi_id,
   b.Nombres as nombre_dueño_publi,
   b.Apellidos as apellido_dueño_publi,
   a.miembro_idmiembro as notificador_id,
   c.nombres as Nombres_notificador
  FROM
    notificacion as a,
    vista_publicacion as b,
    vista_perfil as c,
    tipo_notificacion as d
  WHERE
   b.idpublicacion = a.publicacion_idpublicacion and
   c.Miembro =  a.miembro_idmiembro and
   d.idtipo_notificacion = a.tipo_notificacion_idtipo_notificacion;

CREATE VIEW correo_admin
 AS SELECT
   a.miembro_idmiembro as idmiembro,
   a.tipo_estado_idtipo_estado as tipo_estado,
   b.correo
  from
   estado as a,
   correo as b
  where
   tipo_estado_idtipo_estado  = '4' and
   a.miembro_idmiembro = b.miembro_idmiembro;
  
 
CREATE VIEW mini_avatar
 AS  SELECT 
      imagen,
      miembro,
      idpublicacion,
      fecha,
      tiempo
    FROM 
      vista_publicacion 
    WHERE
      miembro = miembro and 
      (idtipo_publi = 8 or
      idtipo_publi = 9 or
      idtipo_publi = 10);
/*
select 
a.nombres 
from 
who_percepcionchivo as a, 
vista_publicacion 
where 
idpublicacion = a.numero_publicacion;
*/

/*select
  miembro_persive,
  numero_publicacion
from
  who_percepcionchivo
where
  miembro_persive = 1 and
  numero_publicacion = 2;
  */
  
/*    update
        perfil 
      set
        carrera_idcarrera ='2',
        carrera_facultad_idfacultad ='2'
      where 
        miembro_idmiembro ='2'
        ;

      update
        perfil 
      set
        domicilio ='San Salvador'
      where 
        miembro_idmiembro ='2'
        ;

      update
        perfil 
      set
        frase ='Cualesquiera que sean tus circunstancias personales,
         Dios es poderoso para cambiarlas en un instante, para crear 
         nuevos caminos y nuevas oportunidades, pero lo hará en Su tiempo y conforme a Su voluntad. '
      where 
        miembro_idmiembro ='2'
        ;
        */
