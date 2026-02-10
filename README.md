## Rustfs laravel s3 reprod

1. Start docker-compose for test env
2. Run laravel migrations
`php artisan migrate`
3. Create RustFS bucket in admin ui `bucket`
4. Create ACLs to test with if needed
4. run php artisan testfs to test exists usage.
