# Project Context: LaraSaaS Core

## 1. Project Overview
**Name:** LaraSaaS Core
**Goal:** A high-performance, scalable, multi-tenant SaaS backend engine.
**Status:** **PROJECT INITIALIZATION (GREENFIELD)**. Building the core architectural foundations.

### Scope & Vision
This project serves as the **Backend API** for a B2B SaaS platform. It is designed to be consumed by a Next.js Frontend. The architecture prioritizes long-term maintainability, testability, and strict data isolation between tenants.

### Main Features (Roadmap)
* **Multi-Tenancy:** Logic isolation of data per "Tenant" (Company/Organization).
* **Identity Management:** Robust Authentication (AuthN) and Authorization (AuthZ) using RBAC (Roles & Permissions).
* **API-First Design:** RESTful endpoints with strict contracts for the Frontend.
* **Modular Design:** Independent modules (Identity, Billing, Notifications) to allow future extraction into Microservices if needed.
* **Observability:** Centralized logging, health checks, and performance monitoring.

## 2. Technology Stack
* **Language:** PHP 8.3 (Strict typing, Readonly classes).
* **Framework:** Laravel 12 (Strictly as Infrastructure Layer).
* **Database:** PostgreSQL 16 (Primary DB).
* **Cache/Queue:** Redis.
* **Search Engine:** Meilisearch.
* **Testing:** PEST PHP.
* **Environment:** Docker (Laravel Sail) via WSL2.

## 3. Architectural Rules (The "Law")
We strictly adhere to **Domain-Driven Design (DDD)** and **Hexagonal Architecture**.

### A. Domain Layer (`src/{Module}/Domain`)
* **Definition:** The heart of the software. Pure Business Logic.
* **Dependencies:** ZERO. Cannot depend on Laravel, Eloquent, or external libraries.
* **Components:**
    * **Entities:** `final class`, private properties, rich domain behavior.
    * **Value Objects:** Immutable, self-validating.
    * **Ports:** Interfaces defining contracts (e.g., `TenantRepository`).
    * **Exceptions:** Domain-specific errors.

### B. Application Layer (`src/{Module}/Application`)
* **Definition:** Orchestration layer.
* **Dependencies:** Depends ONLY on Domain.
* **Components:**
    * **Use Cases:** Single responsibility actions (e.g., `CreateTenantUseCase`).
    * **DTOs:** Data Transfer Objects.
* **Rule:** NO business logic here. Just fetch data -> call domain -> save data.

### C. Infrastructure Layer (`src/{Module}/Infrastructure`)
* **Definition:** The "Real World" adapters.
* **Dependencies:** Depends on Application and Domain.
* **Components:**
    * **Persistence:** Eloquent Models, Repository Implementations.
    * **Http:** Controllers (Skinny), API Resources, FormRequests.
    * **Framework:** ServiceProviders, Jobs, Console Commands.

## 4. Coding Standards
1.  **Strict Types:** ALL files must start with `declare(strict_types=1);`.
2.  **Return Types:** Always explicit (use `void` if nothing is returned).
3.  **No Magic:** Avoid Laravel magic methods (`__get`) inside Domain.
4.  **Eloquent Isolation:** Eloquent Models must NEVER be returned by a Repository Port. They must be mapped to Domain Entities before leaving the Infrastructure layer.

## 5. User Preferences (Joaquín's Workflow)
* **Full Files:** When generating code, ALWAYS provide the **complete file content**.
* **Discussion First:** Before implementing a new feature, briefly discuss the architectural approach.
* **Language:** Explanations in **Spanish**. Code in **English**.
* **Tone:** Professional, insightful, architecture-focused.