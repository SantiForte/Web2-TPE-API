# Web2-TPE-API
TPE de Web2 parte 3 (Tadeo y Santiago)

no pude verificar bien el jwt no tengo la contraseña del usuario, andaba todo no tenia errores pero cuando le puse el jwt no pude probar si estaba bien
falta hacer el readme pero despues creo que esta casi todo


Base URL: http://localhost/Web2-TPE-API/api/

Autenticación(Obtener Token)

Endpoint
POST /auth/token
Body
{
  "usuario": "webadmin",
  "password": "1234"
}
Respuesta 
{
  "token": "eyJhbGciOi..."
}
----------------------------------------------
Futbolistas(Obtener listado de futbolistas)
Endpoint
GET /futbolistas

Ejemplo
GET /futbolistas
Respuesta
[
  {
    "id_jugador": 1,
    "nombre": "lautaro",
    "apellido": "martinez"
    "fecha_nacimiento": "1997-08-22",
    "nacionalidad": "Argentina",
    "posicion": "Delantero",
    "id_club": 1
  },
  ...
]
--------------------------------------------------
Ordenamiento
Endpoint
GET /futbolistas?sort=nombre&order=ASC

Parámetros
sort	= Campo por el cual ordenar
order	= ASC o DESC

Ejemplo
GET /futbolistas?sort=apellido&order=DESC
Respuesta:
[
  {
    "id_jugador": 1,
    "nombre": "lautaro",
    "apellido": "martinez"
  },
  ...
]
-------------------------------------------------
Paginación
Endpoint
GET /futbolistas?page=1&limit=2
Parámetros
Parámetro	Descripción
page	Número de página
limit	Cantidad de registros por página
Ejemplo
GET /futbolistas?page=2&limit=2
Obtener futbolista por ID
Endpoint
GET /futbolistas/{id}
Ejemplo
GET /futbolistas/1
Respuestas

200 OK

404 Not Found

Actualizar futbolista
Endpoint
PUT /futbolistas/{id}
Requiere autenticación JWT

Header:

Authorization: Bearer TOKEN
Body
{
  "nombre": "Luis",
  "apellido": "Henrique",
  "fecha_nacimiento": "1998-07-08",
  "nacionalidad": "Brasil",
  "posicion": "Extremo",
  "id_club": 1
}
