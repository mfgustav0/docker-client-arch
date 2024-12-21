# Documentação da API do Módulo Docker

## Visão Geral
Este repositório fornece uma arquitetura modular para gerenciar containers e imagens Docker usando PHP. O projeto foi desenvolvido com o intuito de estudar TDD e Clean Architecture. A estrutura do projeto é organizada para suportar escalabilidade, separação de responsabilidades e facilidade de manutenção.

---

## Estrutura do Projeto

A estrutura do projeto segue os princípios da arquitetura limpa (Clean Architecture), com uma separação bem definida entre as camadas:

- **Application**: Camada responsável por configurar os serviços e provedores necessários para o funcionamento do sistema. Inclui:
    - **Providers**: Registro de serviços e dependências.
    - **Services**: Lógica específica de aplicação.
- **Domain**: Camada que encapsula as regras de negócio e abstrações fundamentais do sistema. Inclui:
    - **Entities**: Representações das entidades do domínio.
    - **Interfaces**: Contratos para repositórios e serviços que devem ser implementados.
        - **Repositories**: Contratos para acesso a dados e persistência.
        - **Services**: Contratos para lógica de negócio específica.
- **Infrastructure**: Camada que implementa detalhes de infraestrutura, conectando a lógica do domínio à tecnologia subjacente. Inclui:
    - **Mappers**: Transformação entre entidades e formatos necessários para infraestrutura.
    - **Repository**: Implementações concretas de persistência ou chamadas externas.
- **Presentation**: Camada que gerencia a interação com o cliente por meio de interfaces HTTP. Inclui:
    - **Http**: Comunicação com clientes.
        - **Controllers**: Controladores que lidam com requisições e respostas HTTP.

Essa organização facilita a manutenção, escalabilidade e o isolamento de responsabilidades dentro do projeto.

---

## Endpoints da API

### **Containers**

#### **Listar Containers**
**GET** `{url}/containers?all=false`

- **Descrição:** Retorna uma lista de containers. O parâmetro `all` define se todos os containers ou apenas os ativos serão listados.
- **Cabeçalhos:**
  - Content-Type: `application/json`
  - Accept: `application/json`

#### **Criar Container**
**POST** `{url}/containers`

- **Descrição:** Cria um novo container com base nos dados fornecidos.
- **Cabeçalhos:**
  - Content-Type: `application/json`
  - Accept: `application/json`
- **Corpo:**
```json
{
    "image": "{{image}}",
    "name": "{{name}}"
}
```

#### **Iniciar Container**
**POST** `{url}/containers/{containerId}/start`

- **Descrição:** Inicia um container existente identificado pelo `containerId`.
- **Cabeçalhos:**
  - Content-Type: `application/json`
  - Accept: `application/json`

#### **Parar Container**
**PUT** `{url}/containers/{containerId}/stop`

- **Descrição:** Interrompe um container em execução identificado pelo `containerId`.
- **Cabeçalhos:**
  - Content-Type: `application/json`
  - Accept: `application/json`

#### **Destruir Container**
**DELETE** `{url}/containers/{containerId}`

- **Descrição:** Remove um container existente identificado pelo `containerId`.
- **Cabeçalhos:**
  - Content-Type: `application/json`
  - Accept: `application/json`

---

### **Imagens**

#### **Listar Imagens**
**GET** `{url}/images?all=false`

- **Descrição:** Retorna uma lista de imagens. O parâmetro `all` define se todas as imagens ou apenas as disponíveis localmente serão listadas.
- **Cabeçalhos:**
  - Content-Type: `application/json`
  - Accept: `application/json`

#### **Exibir Imagem**
**GET** `{url}/images/{imageId}`

- **Descrição:** Retorna detalhes de uma imagem específica identificada pelo `imageId`.
- **Cabeçalhos:**
  - Content-Type: `application/json`
  - Accept: `application/json`
