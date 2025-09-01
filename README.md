
# PHP Flight REST API Lab

A comprehensive REST API implementation for flight management system built with PHP using Object-Oriented Programming, MVC design pattern, and PDO database connectivity.

## Project Overview

This lab demonstrates the implementation of a professional-grade REST API using modern PHP development practices. The API manages airline data through a complete CRUD interface while showcasing enterprise-level architectural patterns.

## Technologies Used

- **PHP 8.2+** - Server-side programming language
- **MySQL/MariaDB** - Database management system
- **PDO** - PHP Data Objects for database abstraction
- **Apache** - Web server with mod_rewrite
- **XAMPP** - Local development environment
- **Git** - Version control system

## Architecture & Design Patterns

### MVC (Model-View-Controller) Pattern
- **Models** (`models/`) - Data layer handling database operations
- **Controllers** (`controllers/`) - Business logic and request handling
- **Views** - JSON responses (API endpoints)

### Object-Oriented Programming
- Class inheritance with `extends` keyword
- Encapsulation through private/protected properties
- Method overriding and polymorphism
- Exception handling with try-catch blocks

### Database Design
- PDO with prepared statements for security
- Connection pooling and error handling
- Direct SQL queries for maximum compatibility
- Proper parameter binding to prevent SQL injection

## Project Structure

```
IBL-FLIGHT-LAB-4-AND-5/
├── config/
│   └── DB.php                    # Database connection class
├── models/
│   └── Airline.php              # Airline data model
├── controllers/
│   └── airlineOperations.php    # REST API controller
├── api/
│   └── .htaccess               # URL rewriting rules
├── tests/
│   └── postman/                # API test collections
├── .gitignore                  # Git ignore patterns
├── README.md                   # Project documentation
└── index.php                   # API entry point
```

## Database Schema

The API connects to the `IBL_FLIGHTS_LABS` database with the following key table:

### `airline` Table
```sql
CREATE TABLE airline (
  id int NOT NULL AUTO_INCREMENT,
  airline_name varchar(50) NOT NULL,
  logo varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
);
```

## API Endpoints

### Base URL
```
http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/
```

### Airline Management

| Method | Endpoint | Description | Request Body |
|--------|----------|-------------|--------------|
| GET | `/airlines` | Retrieve all airlines | None |
| GET | `/airlines/{id}` | Get specific airline by ID | None |
| POST | `/airlines` | Create new airline | JSON with airline_name, logo |
| PUT | `/airlines/{id}` | Update existing airline | JSON with airline_name, logo |
| DELETE | `/airlines/{id}` | Delete airline | None |

### Request/Response Format

#### Successful Response
```json
{
    "status": "success",
    "message": "Operation completed successfully",
    "data": { /* response data */ },
    "timestamp": "2025-09-01 19:48:35"
}
```

#### Error Response
```json
{
    "status": "error",
    "message": "Error description",
    "timestamp": "2025-09-01 19:48:35"
}
```

## Installation & Setup

### Prerequisites
- XAMPP (Apache, MySQL, PHP 8.2+)
- Git
- Command line access
- Web browser or API testing tool (Postman)

### Installation Steps

1. **Clone the repository**
   ```bash
   cd /Applications/XAMPP/xamppfiles/htdocs
   git clone https://github.com/yourusername/IBL-FLIGHT-LAB-4-AND-5.git
   cd IBL-FLIGHT-LAB-4-AND-5
   ```

2. **Start XAMPP services**
   ```bash
   sudo /Applications/XAMPP/xamppfiles/xampp start
   ```

3. **Import database**
   - Open http://localhost/phpmyadmin
   - Create database: `IBL_FLIGHTS_LABS`
   - Import the provided SQL file
   - Ensure collation is set to `utf8mb4_general_ci`

4. **Configure database connection**
   - Verify `config/DB.php` settings:
   ```php
   private $host = 'localhost';
   private $dbname = 'IBL_FLIGHTS_LABS';
   private $username = 'root';
   private $password = '';  // Empty for default XAMPP
   ```

5. **Test the installation**
   ```bash
   curl http://localhost/IBL-FLIGHT-LAB-4-AND-5/
   ```

## Usage Examples

### Get All Airlines
```bash
curl http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/airlines
```

### Get Specific Airline
```bash
curl http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/airlines/1
```

### Create New Airline
```bash
curl -X POST http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/airlines \
  -H "Content-Type: application/json" \
  -d '{"airline_name": "Emirates Airlines", "logo": "emirates_logo.png"}'
```

### Update Airline
```bash
curl -X PUT http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/airlines/1 \
  -H "Content-Type: application/json" \
  -d '{"airline_name": "Updated Airline Name", "logo": "new_logo.png"}'
```

### Delete Airline
```bash
curl -X DELETE http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/airlines/2
```

## Code Architecture Details

### Database Layer (`config/DB.php`)
- Singleton pattern for connection management
- PDO configuration with error handling
- Prepared statement support
- Connection pooling and resource management

### Model Layer (`models/Airline.php`)
- Extends base DB class
- CRUD operations with error handling
- Data validation and sanitization
- Proper exception propagation

### Controller Layer (`controllers/airlineOperations.php`)
- RESTful routing implementation
- HTTP method handling (GET, POST, PUT, DELETE)
- JSON input/output processing
- Comprehensive error handling
- CORS headers for cross-origin requests

### URL Routing (`api/.htaccess`)
- Clean URL implementation
- Apache mod_rewrite configuration
- Request forwarding to appropriate controllers
- Parameter extraction and processing

## Security Features

- **SQL Injection Prevention** - Prepared statements with parameter binding
- **Input Validation** - Server-side data validation and sanitization
- **Error Handling** - Structured exception handling without information leakage
- **CORS Configuration** - Controlled cross-origin resource sharing
- **HTTP Method Validation** - Proper REST method enforcement

## Testing

### Manual Testing with cURL
All endpoints have been tested using cURL commands as shown in the usage examples.

### Postman Testing
Import the provided Postman collection with:
- Environment variable: `base_url = http://localhost/IBL-FLIGHT-LAB-4-AND-5/api`
- Test cases for all CRUD operations
- Response validation and error handling tests

### Browser Testing
- Main API documentation: http://localhost/IBL-FLIGHT-LAB-4-AND-5/
- Direct endpoint access for GET operations

## Development Workflow

### Local Development
```bash
# Navigate to project directory
cd /Applications/XAMPP/xamppfiles/htdocs/IBL-FLIGHT-LAB-4-AND-5

# Start development server (XAMPP)
sudo /Applications/XAMPP/xamppfiles/xampp start

# Make changes and test
curl http://localhost/IBL-FLIGHT-LAB-4-AND-5/api/airlines

# Commit changes
git add .
git commit -m "Description of changes"
git push origin main
```

### Code Standards
- PSR-4 autoloading standards
- Consistent naming conventions
- Comprehensive error handling
- Proper code documentation
- Separation of concerns

## Troubleshooting

### Common Issues

**Database Connection Failed**
- Verify MySQL service is running
- Check database credentials in `config/DB.php`
- Ensure database `IBL_FLIGHTS_LABS` exists

**404 Not Found Errors**
- Verify Apache mod_rewrite is enabled
- Check `.htaccess` file exists in `api/` directory
- Confirm project is in XAMPP htdocs directory

**Permission Denied**
```bash
chmod -R 755 /Applications/XAMPP/xamppfiles/htdocs/IBL-FLIGHT-LAB-4-AND-5
```

**MySQL Compatibility Issues**
- The project uses direct SQL queries instead of stored procedures
- Compatible with MySQL 5.7+ and MariaDB 10.4+
- Handles utf8mb4 charset automatically

## Future Enhancements

- Authentication and authorization system
- Rate limiting and API quotas  
- Comprehensive logging system
- API versioning implementation
- Additional entity endpoints (flights, bookings, passengers)
- Input validation middleware
- Caching layer implementation
- API documentation with Swagger/OpenAPI

## Learning Objectives Met

This lab successfully demonstrates:

1. **Object-Oriented Programming**
   - Class design and inheritance
   - Encapsulation and abstraction
   - Error handling with exceptions

2. **MVC Architecture**
   - Clear separation of concerns
   - Reusable model classes
   - RESTful controller design

3. **Database Integration**
   - PDO implementation with prepared statements
   - Secure database operations
   - Proper connection management

4. **RESTful API Design**
   - HTTP method implementation
   - JSON request/response handling
   - Proper status code usage

5. **Professional Development Practices**
   - Version control with Git
   - Code documentation
   - Error handling and validation
   - Security considerations

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/new-endpoint`)
3. Commit changes (`git commit -am 'Add new feature'`)
4. Push to branch (`git push origin feature/new-endpoint`)
5. Create Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments

- Built for IBL Flight Management System
- Uses XAMPP for local development environment
- Implements industry-standard REST API practices
- Follows PHP best practices and security guidelines

---

**lab Status**: Complete and Fully Functional
**Last Updated**: September 2025
**Version**: 1.0.0
