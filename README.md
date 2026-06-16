# Web2-TPE-API
TPE de Web2 parte 3 (Tadeo y Santiago)

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
    "fecha_nacimiento": "1998-05-08",
    "nacionalidad": "argentina",
    "posicion": "delantero",
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
    "fecha_nacimiento": "1998-05-08",
    "nacionalidad": "argentina",
    "posicion": "delantero",
    "id_club": 1
  },
  ...
]
-------------------------------------------------
Paginación
Endpoint
GET /futbolistas?page=1&limit=2

Parámetros
page	= Número de página
limit	= Cantidad de registros por página

Ejemplo
GET /futbolistas?page=2&limit=2
Respuesta:
[
  {
    "id_jugador": 1,
    "nombre": "lautaro",
    "apellido": "martinez"
    "fecha_nacimiento": "1998-05-08",
    "nacionalidad": "argentina",
    "posicion": "delantero",
    "id_club": 1
  },
  ...
]
--------------------------------------------------
Obtener futbolista por ID
Endpoint
GET /futbolistas/{id}

Ejemplo
GET /futbolistas/1
Respuesta:
[
  {
    "id_jugador": 1,
    "nombre": "lautaro",
    "apellido": "martinez"
    "fecha_nacimiento": "1998-05-08",
    "nacionalidad": "argentina",
    "posicion": "delantero",
    "id_club": 1
  }
]
------------------------------------------------
Actualizar futbolista
Endpoint
PUT /futbolistas/{id}
Requiere autenticación JWT

Header:
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF91c3VhcmlvIjoyLCJ1c3VhcmlvIjoid2ViYWRtaW4iLCJyb2wiOiJhZG1pbiIsImV4cCI6MTc4MTYyNzc2Nn0.ewygcYZMmfKNzwgj6Ts_etQNRu6Q0jOfl5wQIvQjroo
Content-Type applicatio/json
Body
{
  "nombre": "Luis",
  "apellido": "Henrique",
  "fecha_nacimiento": "1998-07-08",
  "nacionalidad": "Brasil",
  "posicion": "Extremo",
  "id_club": 1
}
