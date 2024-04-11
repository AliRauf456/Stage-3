BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "user" (
	"userid"	INTEGER,
	"firstname"	TEXT,
	"surname"	TEXT,
	"password"	TEXT,
	PRIMARY KEY("userid")
);
CREATE TABLE IF NOT EXISTS "Broker" (
	"brokerid"	INTEGER,
	"broker_name"	TEXT,
	"address"	TEXT,
	"phone"	TEXT,
	"email"	TEXT,
	PRIMARY KEY("brokerid")
);
CREATE TABLE IF NOT EXISTS "lender" (
	"lenderid"	INTEGER,
	"lender_name"	TEXT,
	"address"	TEXT,
	"phone"	TEXT,
	"email"	TEXT,
	PRIMARY KEY("lenderid")
);
CREATE TABLE IF NOT EXISTS "personal_details" (
	"personal_details_id"	INTEGER,
	"user_id"	INTEGER NOT NULL,
	"email"	TEXT NOT NULL,
	"date_of_birth"	DATE NOT NULL,
	"address"	TEXT NOT NULL,
	"mobile_number"	TEXT NOT NULL,
	PRIMARY KEY("personal_details_id"),
	FOREIGN KEY("user_id") REFERENCES "users"("user_id")
);
CREATE TABLE IF NOT EXISTS "financial_details" (
	"financial_details_id"	INTEGER,
	"user_id"	INTEGER NOT NULL,
	"annual_income"	DECIMAL(10, 2) NOT NULL,
	"savings"	DECIMAL(10, 2) NOT NULL,
	"debts"	DECIMAL(10, 2) NOT NULL,
	PRIMARY KEY("financial_details_id"),
	FOREIGN KEY("user_id") REFERENCES "users"("user_id")
);
CREATE TABLE IF NOT EXISTS "user_selection" (
	"user_selection_id"	INTEGER,
	"user_id"	INTEGER NOT NULL,
	"mortgage_product_id"	INTEGER NOT NULL,
	PRIMARY KEY("user_selection_id"),
	FOREIGN KEY("mortgage_product_id") REFERENCES "mortgage_products"("mortgage_product_id"),
	FOREIGN KEY("user_id") REFERENCES "users"("user_id")
);
CREATE TABLE IF NOT EXISTS "mortgage_product" (
	"mortgage_product_id"	INTEGER,
	"lender_id"	INTEGER NOT NULL,
	"broker_id"	INTEGER NOT NULL,
	"product_name"	VARCHAR(100) NOT NULL,
	"interest_rate"	DECIMAL(5, 2) NOT NULL,
	"loan_term"	INT NOT NULL,
	"maximum_loan_amount"	DECIMAL(15, 2) NOT NULL,
	"minimum_down_payment"	DECIMAL(10, 2) NOT NULL,
	PRIMARY KEY("mortgage_product_id"),
	FOREIGN KEY("broker_id") REFERENCES "brokers"("broker_id"),
	FOREIGN KEY("lender_id") REFERENCES "lenders"("lender_id")
);
COMMIT;
