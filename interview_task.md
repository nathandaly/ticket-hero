# Arbor Senior Product Engineer -- Interview Task

## Overview

At Arbor, every developer is considered a **Hero**. A leaderboard system
tracks progress based on completed Jira tickets (called *Quests*). Each
completed ticket awards experience points (**XP**) depending on its
difficulty.

------------------------------------------------------------------------

## Assignment

Build an application that supports:

### Adding a Completed Ticket

Each ticket must include:

-   `heroName` (string)\
-   `ticketId` (string, e.g. `JIRA-123`)\
-   `difficulty` (integer 1--5)

**Rules:**

-   A ticket must **not be counted more than once**, even if submitted
    again.

------------------------------------------------------------------------

### Retrieving the Leaderboard

The leaderboard must display:

-   Hero name\
-   Total XP\
-   Number of completed tickets

**Sorting:**

-   Sorted by **Total XP (descending)**
-   If two heroes have the same XP, ordering is flexible

------------------------------------------------------------------------

## XP Mapping

  Difficulty   XP
  ------------ ----
  1            10
  2            20
  3            30
  4            40
  5            50

------------------------------------------------------------------------

## Technical Constraints

-   **Language:** PHP\
-   **Version:** 8.2+\
-   **Storage:** MySQL\
-   **Interface:** Simple HTTP API (your choice)

------------------------------------------------------------------------

## Not Required

-   Authentication\
-   UI / frontend\
-   External services\
-   Full Jira integration\
-   Framework usage (optional)

------------------------------------------------------------------------

## Expectations

-   Keep the solution **simple and readable**
-   Use **clear naming** and basic domain concepts
-   Focus on **correctness over features**
-   Be ready to **explain design decisions**

------------------------------------------------------------------------

## Example Scenario

### Input

``` php
addTicket("Alice", "JIRA-101", 3);
addTicket("Bob", "JIRA-102", 5);
addTicket("Alice", "JIRA-103", 2);
```

### Output (Leaderboard)

    1. Alice – 50 XP (2 tickets)
    2. Bob   – 50 XP (1 ticket)

------------------------------------------------------------------------

## Prerequisites

Come prepared with:

-   IDE of your choice\
-   Skeleton of the project

------------------------------------------------------------------------

## Follow-Up

After completing the task, expect discussion around:

-   How the application could be expanded\
-   Potential enhancements to your solution
