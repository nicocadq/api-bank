# API-Bank

Ejercicio para Programación Web I, implementación de una API en base a endpoints y comportamientos

## Requerimientos dados

-   Crear una cuenta, con un `email` y un `monto` en 0

```
@POST('/api/balance', {
 email: string
})

caso feliz -> expect({ id: int, email: string, monto: int = 0 }, 201)

`email` ya existe -> expect({error: 'Este email ya existe'}, 400)
```

-   Ver una cuenta a travez a su `id`

```
@GET('/api/balance/:id')

caso felix -> expect({ id: int, email: string, monto: int }, 200)

no encuentra la cuenta -> expect(404)
```

-   Hacer un deposito

```
@POST('/api/evento', {
 tipo: string = 'deposito',
 destino: int = (id de una cuenta),
 monto: int = (ex. 100)
})


caso feliz -> expect({ id: int, email: string, monto: int ( +100) }, 200)

no encuentra el `destino` -> expect(404)
```

-   Hacer un retiro

```
@POST('/api/evento', {
 tipo: string = 'retiro',
 origen: int = (id de una cuenta),
 monto: int = (ex. 100),
 token?: int
})

`monto` <= 1000 y encuentra `origen` -> expect({ id: int, email: string, monto: int ( -100) }, 200)

`monto` > 1000, encuentra `origen`, `token` valido ->
 expect({
  id: int,
  email: string,
  monto: int ( -100),
 }, 200)

`monto` > 1000, encuentra `origen`, sin `token` o `token` invalido ->
 expect({ error: 'Token invalido, enviamos un token a su email' }, 400)  + Email con el Token necesario

salgo insuficiente -> expect({ error: 'Saldo insuficiente' }, 400)

no encuentra el `origen` -> expect(404)
```

-   Hacer una transferencia

```
@POST('/api/evento', {
 tipo: string = 'transferencia',
 origen: int = (id de una cuenta),
 destino: int = (id de una cuenta),
 monto: int = (ex. 100)
})

caso feliz -> expect([
 { id: int, email: string, monto: int ( -100) },
 { id: int, email: string, monto: int ( +100) }
], 200)

no encuentra `origen` o `destino` -> expect(404)
```

## Postman Collection

Dejo una Postman Collection en el root del proyecto, donde estan algunas request de prueba.

## Levantar API

-   `composer install`
-   `php artisan migrate`
-   `php artisan serve`

Implemente unos test basicos para probar las requerimientos iniciales del Ejercicio

-   `php artisan test`
