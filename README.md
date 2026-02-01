Nuru AI – National Intelligence Early Warning & Audit Intelligence Platform

Nuru AI is a secure, AI-powered intelligence system designed to help investigative agencies detect risks, verify documents, and uncover irregular financial patterns with speed and accuracy. The platform serves national bodies such as the EACC, Auditor-General, procurement units, and other government audit institutions that require fast, reliable, and traceable insights.

Nuru AI blends machine learning, document intelligence, anomaly detection, and structured workflows into one centralized system built for national-level investigations.

Mission

To provide a trusted, AI-driven intelligence platform that strengthens government audit processes, supports anti-corruption efforts, and enhances early detection of suspicious activities across Kenya.

The Problem

Investigative agencies handle millions of documents, transactions, and procurement records. Manual verification is slow, prone to human error, and creates opportunities for fraud to go undetected.

Agencies need:

Real-time insights

Automated document verification

Risk scoring

Secure audit trails

Fast reporting

Scalable intelligence tools

Nuru AI solves these challenges by automating the investigative workflow end-to-end.

Core Features
AI Document Verification

Reads procurement records, tender documents, financial statements, and contracts. Extracts key fields and checks for inconsistencies.

Real-Time Risk Scoring

AI models compute corruption risk indicators based on patterns, anomalies, and historical data.

Transaction Monitoring Dashboard

Visual monitors of spending patterns, supplier histories, and unusual transactions.

Audit Trail & Case Tracking

Every action is logged for accountability and future reference.

Secure User Roles

Officers, auditors, supervisors, and admins all have controlled privileges.

System Architecture Overview (High-Level)

Frontend (React)
Interactive dashboards for document verification, case analytics, transaction monitoring, and visual reporting.

Backend (Django + PostgreSQL)
Handles authentication, API endpoints, data storage, audit logs, and security rules.

AI Engine (Python Micro-Services)
Document analysis
Risk modeling
Fraud pattern detection
Anomaly scoring

Database Layer
Encrypted PostgreSQL with strict access policies.

Security Layer
Encryption, access controls, logging, secure API gateway.

Tech Stack

Frontend: React + Tailwind/Material UI

Backend: Django REST Framework

Database: PostgreSQL

AI: Python (Transformers, OCR, anomaly detection models)

Deployment: Docker, Railway/Render, GitHub Actions

Security Approach

Security isn’t an afterthought — it is the foundation of Nuru AI.
This system is built with confidentiality, integrity, and traceability as primary design principles.

1. Data Security

All data encrypted at rest using PostgreSQL encryption.

All connections use HTTPS/TLS 1.3.

No sensitive keys stored in code repositories.

2. Access Control

Role-Based Access Control (RBAC) for auditors, investigators, supervisors, and admins.

All privileged actions require elevated authentication.

Suspicious login attempts trigger alerts.

3. API Security

JWT + rotating refresh tokens.

IP whitelisting capability for sensitive routes.

Strict input validation to prevent injection attacks.

4. Audit Logging

Every user action is logged with timestamp, IP, and purpose.

Immutable logs stored separately from application database.

5. AI Model Integrity

All model outputs include confidence scores.

Models versioned and stored behind protected endpoints.

6. DevSecOps

CI pipeline scans dependencies for vulnerabilities.

Automatic secret detection to prevent accidental leaks.

Regular dependency patching policy.

Nuru AI is built with the understanding that national investigative data must be handled with extreme caution, traceability, and integrity.

Team

Backend Lead – Briton

AI & Systems Research – Brayo & Leslie

Frontend Lead – Maxwell Kiptoo

Project Coordination & Security Oversight – Team Nuru AI

Vision

Nuru AI aims to become Kenya’s trusted intelligence companion — a tool that empowers investigators, protects public funds, and strengthens national accountability structures.

The project continues evolving, but the purpose remains constant:
Illuminate the truth. Strengthen the nation.
