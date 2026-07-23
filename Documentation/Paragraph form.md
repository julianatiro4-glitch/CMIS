# CMIS — System Documentation (Paragraph Form)

This document describes what the **Computer Management Inventory System (CMIS)** application contains today, based on the Laravel codebase in this repository (routes, models, controllers, views, and database structure). It is written in paragraph form for use in proposals, manuals, or project submissions.

## Overview

CMIS is a web application for the Quezon City Public Employment Service Office (QC PESO). It is intended to track office computers and related equipment: what items exist, how they are classified, where they sit in the organization, who uses them, their operational status and physical condition, and supporting details such as specifications, warranty, and maintenance history. The user interface uses a fixed sidebar layout branded for QC PESO, with Tailwind CSS loaded from a CDN. Most features require login; a public asset lookup page is available by asset tag without signing in.

## Objectives (as reflected in the application)

The system supports recording and organizing hardware inventory, monitoring status and condition fields on each asset, logging maintenance work, giving administrators a dashboard summary, exporting asset data for reporting, and maintaining an audit trail of changes. Role-based access separates full operators from read-only staff. The codebase is organized so that inventory (assets, categories, locations, divisions) forms the core, with authentication, maintenance, activity logging, and reporting layered on top.

## Phase 1 — Inventory (system of record)

Phase 1 capability is implemented around **equipment records**. Each asset has a unique asset tag (for example CMP-0001), a name, category, optional location and PESO division, serial number, status, condition, purchase and warranty fields where used, and extended IT fields (CPU, RAM, storage, operating system, hostname, utilized-by text, ownership, connectivity, CrowdStrike flag, and software notes). Assets support soft delete with a trash view, restore, and permanent delete for authorized roles. Staff with Admin or IT Staff roles can create, edit, bulk-delete, and retire items; all authenticated users can list and view assets.

**Categories** and **locations** are managed through standard CRUD screens. **Divisions** represent the eight PESO organizational units (PED, LMISD, ADMIN, SPD, OPM, LRSD, DOC, MSD) and can be linked to a location. Equipment **status** values in the model are Available, In Use, Under Maintenance, Defective, and For Replacement. **Search and filtering** on the asset index include keyword search (tag, name, serial, utilized-by, CPU), status, and division; CSV export respects the same filters. Printable **asset labels** and a **lookup** page by tag support physical inventory workflows.

A **REST API** under `/api/v1` exposes assets, categories, and locations as API resources. Route comments indicate Phase 2 hardening with Sanctum; in the current tree the API is not wrapped in authentication middleware in `routes/api.php`, and API routing may need to be enabled in the application bootstrap if not already registered.

## Phase 2 — Accountability (users, assignments, maintenance)

**User accounts** use email and password login (custom controller, no Breeze). Roles are **admin**, **it_staff**, and **viewer**. Admin and IT Staff may manage assets and maintenance tickets; only Admin may manage user accounts. Viewers may browse permitted pages but receive HTTP 403 on create/edit routes protected by the `role:admin,it_staff` middleware.

**Maintenance** tickets link to an asset, support open, in progress, and resolved states, and store issue description, technician, costs, and resolution notes. Creating or updating tickets can drive asset status (for example toward under maintenance while work is open). Maintenance listing is available to authenticated users; creating and editing tickets requires Admin or IT Staff.

**Assignment** (check-out / check-in) is implemented in code (`AssignmentController`, model, requests, views, observer, and database migration) but is **not registered in the active `routes/web.php`** at the time this document was generated, so the assignment screens are not reachable until those routes are wired again. When enabled, checkout assigns an available asset to a user and sets status to In Use; check-in returns the asset to Available and records return condition.

Authentication applies to the main web application. API token auth via Laravel Sanctum is a dependency in `composer.json` and is prepared on the User model but is not fully applied to API routes in the current configuration.

## Phase 3 — Insight and oversight (dashboard, reports, audit, export)

The **dashboard** (authenticated) summarizes total assets and counts by key statuses, assets by category, open maintenance tickets, and warranties expiring within a defined window, with a short “needs attention” summary.

**Reports** are implemented in `ReportController` and a reports view (status, condition, division, category, OS distribution, CrowdStrike coverage, financial totals, warranty buckets, maintenance metrics) but the **reports route is not present in the current `routes/web.php`**, so the reports page is not linked in navigation until restored.

**CSV export** of assets is available from the asset list for authenticated users. An **activity log** records create, update, and delete actions for assets and maintenance records (and assignments when that module is active), viewable on an audit log index for authenticated users.

**Office supplies** (quantity-based stock) have a database migration stub in the repository but no corresponding controllers or navigation in the active application yet. **Automated notifications** (warranty, overdue check-ins, ticket assignment) and **API rate limiting / versioned API docs** are not implemented as first-class features in the current codebase.

## Technical foundation

The project is **Laravel** with Blade views, session-based web auth, Eloquent models, observers for audit logging, and PHPUnit feature tests (including role access and maintenance lifecycle). Sample categories, locations, divisions, and assets can be seeded via `DatabaseSeeder`. The root `README.md` currently contains only a short title; this file is the paragraph-form description of what the system actually provides today and what remains partially wired or planned.
