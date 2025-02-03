# **Campaign API - Project Overview**

## **Project Summary**
The **Campaign API** is a backend service designed to manage **campaigns**, **campaign metrics**, and **performance analytics**. It provides RESTful endpoints for creating, updating, deleting, and retrieving campaign data.

## **Architecture**
The project follows the **Domain-Driven Design (DDD)** architecture, separating business logic into distinct layers:
- **Domain Layer:** Contains core business logic and entities.
- **Application Layer:** Handles service operations and use cases.
- **Infrastructure Layer:** Manages database persistence and external integrations.
- **Presentation Layer:** Provides API endpoints for client communication.

### **Benefits of DDD Architecture:**
- **Scalability:** The separation of concerns allows easier scaling and maintenance.
- **Testability:** Business logic is isolated, making unit testing more effective.
- **Flexibility:** Changes in business logic do not directly impact API structure.
- **Code Maintainability:** Clear boundaries between different layers improve readability and long-term support.

## **Tech Stack**
- **Backend:** Laravel (PHP)
- **Database:** MySQL / PostgreSQL
- **Containerization:** Docker (Optional)
- **Testing:** PestPHP for unit and feature tests
