# Task Flow API

See POSTMAN API Documentation [View Documentation](https://documenter.getpostman.com/view/25154969/2sA3sAi8Jd)
Based on this [Case Study](./md-assets/case-study.pdf)

## Overview

This is a RESTful API for managing tasks within a project. It allows users to create, update, and manage tasks, assign tasks to users, send email notifications, and more.

### Features

-   CRUD Operations for Tasks: Create, Read, Update, and Delete tasks.
-   Task Assignment: Assign tasks to users.
-   Task Status Management: Update the status of tasks (e.g., pending, in progress, completed, overdue).
-   Notification System: Send email notifications when tasks are nearing deadlines or are overdue.
-   Scheduling: Automated tasks for sending reminders and overdue notifications.
-   Role-Based Access Control (RBAC): Middleware to handle roles and permissions.

### Technologies Used

-   Laravel: PHP Framework used for building the API.
-   SQLITE: Database used to store task and user data.
-   Elastic Mail: Service used for sending email notifications in a development environment.
-   Scheduler: To schedule periodic tasks such as sending reminders.

### To Do

1. Implement transactions for critical operations to ensure data consistency.
2. Refactor, remove unused and redundant code.
3. Optimize queries and improve performance by pagination etc.

### License

This project is licensed under the MIT License. See the LICENSE file for details.
