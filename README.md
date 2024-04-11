---

# Guia para Subir e Rodar o Projeto Yii2 com Docker

Este guia mostrará como configurar e executar o seu projeto Yii2 em um ambiente Dockerizado.

## Pré-requisitos

Antes de começar, certifique-se de ter instalado o Docker e o Docker Compose em seu sistema.

## Passos

1. **Definindo Variáveis de Ambiente**

   Crie um arquivo `.env` na raiz do seu projeto com as seguintes variáveis de ambiente:

   ```plaintext
   MYSQL_ROOT_PASSWORD=sua_senha_root
   MYSQL_DATABASE=nome_do_banco
   MYSQL_USER=seu_usuario
   MYSQL_PASSWORD=sua_senha
   ```

   Substitua os valores `sua_senha_root`, `nome_do_banco`, `seu_usuario` e `sua_senha` pelos valores adequados para o seu ambiente.

2. **Subindo os Contêineres Docker**

   Abra um terminal na raiz do seu projeto e execute o seguinte comando para subir os contêineres Docker:

   ```bash
   docker-compose up -d
   ```

3. **Acesso ao Container PHP**

   Para acessar o container PHP, execute o seguinte comando no terminal:

   ```bash
   docker exec -it nome_do_container_php bash
   ```

   Substitua `nome_do_container_php` pelo nome do seu contêiner PHP.

4. **Rodando Composer**

   Dentro do container PHP, execute o Composer para instalar as dependências do Yii2:

   ```bash
   composer install
   ```

5. **Rodando as Migrations**

   Ainda dentro do container PHP, execute as migrations do Yii2 para criar as tabelas no banco de dados:

   ```bash
   php yii migrate
   ```

6. **Criando um Usuário**

   Você pode criar um usuário no banco de dados utilizando o comando Yii2 `user/create`. Substitua `name`, `username` e `password` pelos valores desejados:

   ```bash
   php yii user/create name username password
   ```





## API Documentation
### Login Endpoint
- **URL:** `/api/auth/login`
- **Method:** POST
- **Description:** Login to the system and obtain the access token.
- **Body:**

```json
{
    "username": "seu_usuario",
    "password": "sua_senha"
}
```
- **Response:**
```json
{
    "access_token": "seu_token_de_acesso"
}
```

### Authentication

Para acessar outros endpoints protegidos, é necessário passar o header `Authorization` com o valor `Bearer seu_token_de_acesso`.

Exemplo de Header:
```
Authorization: Bearer seu_token_de_acesso
```

## Customer Endpoint

### Create a Customer

- **URL:** `/customers`
- **Method:** POST
- **Description:** Create a new customer.
- **Body:**
```json
{
    "name": "Customer Test",
    "nif_number": "07097435569",
    "photo_url": "http://google.com",
    "gender": "male"
}
```
- **Response:**
```json
{
    "id": 1,
    "name": "Customer Test",
    "nif_number": "07097435569",
    "photo_url": "http://google.com",
    "gender": "MALE"
}
```

### Get a Customer

- **URL:** `/customers/{id}`
- **Method:** GET
- **Description:** Get details of a specific customer.
- **Response:**
```json
{
    "id": 1,
    "name": "Customer Test",
    "nif_number": "07097435569",
    "photo_url": "http://google.com",
    "gender": "MALE"
}
```

### Update a Customer

- **URL:** `/customers/{id}`
- **Method:** PUT
- **Description:** Update an existing customer.
- **Body:**
```json
{
    "name": "Updated Customer",
    "nif_number": "07097435569",
    "photo_url": "http://google.com",
    "gender": "male"
}
```
- **Response:**
```json
{
    "id": 1,
    "name": "Updated Customer",
    "nif_number": "07097435569",
    "photo_url": "http://google.com",
    "gender": "MALE"
}
```

### Delete a Customer

- **URL:** `/customers/{id}`
- **Method:** DELETE
- **Description:** Delete a customer.
- **Response:**
```json
{
    "message": "Customer deleted successfully"
}
```

## Customer Index Endpoint

### Get Customers with Pagination

- **URL:** `/customers/index?page={page_number}`
- **Method:** GET
- **Description:** Get a list of customers with pagination.
- **Response:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Customer Test",
            "nif_number": "07097435569",
            "photo_url": "http://google.com",
            "gender": "MALE"
        }
    ],
    "_links": {
        "self": {
            "href": "http://baseurl:8000/api/customers?page=1"
        },
        "first": {
            "href": "http://baseurl:8000/api/customers?page=1"
        },
        "last": {
            "href": "http://baseurl:8000/api/customers?page=1"
        }
    },
    "_meta": {
        "totalCount": 1,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}
```

## Product Endpoint

### Create a Product

- **URL:** `/products`
- **Method:** POST
- **Description:** Create a new product.
- **Body:**
```json
{
    "name": "Product Teste",
    "price": 10.99,
    "customer_id": 1
}
```
- **Response:**
```json
{
    "name": "Product Teste",
    "price": 10.99,
    "customer_id": 2,
    "id": 1
}
```

### Get a Product

- **URL:** `/products/{id}`
- **Method:** GET
- **Description:** Get details of a specific product.
- **Response:**
```json
{
    "name": "Product Teste",
    "price": 10.99,
    "customer_id": 2,
    "id": 1
}
```

### Update a Product

- **URL:** `/products/{id}`
- **Method:** PUT
- **Description:** Update an existing product.
- **Body:**
```json
{
    "name": "Updated Product",
    "price": 15.99,
    "customer_id": 1
}
```
- **Response:**
```json
{
    "name": "Updated Product",
    "price": 15.99,
    "customer_id": 1,
    "id": 1
}
```

### Delete a Product

- **URL:** `/products/{id}`
- **Method:** DELETE
- **Description:** Delete a product.
- **Response:**
```json
{
    "message": "Product deleted successfully"
}
```

## Product Index Endpoint

### Get Products with Pagination

- **URL:** `/products/index?page={page_number}&customer_id={customer_id}`
- **Method:** GET
- **Description:** Get a list of products with pagination filtered by customer id.
- **Response:**
```json
{
    "data": [
        {
            "name": "Product Teste",
            "price": 10.99,
            "customer_id": 2,
            "id": 1
        }
    ],
    "_links": {
        "self": {
            "href": "http://baseurl:8000/api/products?page=1&customer_id=1"
        },
        "first": {
            "href": "http://baseurl:8000/api/products?page=1&customer_id=1"
        },
        "last": {
            "href": "http://baseurl:8000/api/products?page=1&customer_id=1"
        }
    },
    "_meta": {
        "totalCount": 1,
        "pageCount": 1,
        "currentPage": 1,
        "perPage": 20
    }
}
```