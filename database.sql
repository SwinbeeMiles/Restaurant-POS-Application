CREATE DATABASE restaurantdatabase;

CREATE TABLE account (
  Username varchar(20) NOT NULL,
  Password varchar(20) NOT NULL,
  AdminPrivilege boolean NOT NULL,
  PRIMARY KEY (Username)
);

INSERT INTO account (Username, Password, AdminPrivilege) 
VALUES ('admin', 'admin', TRUE);

CREATE TABLE menu (
	FoodID varchar(3) NOT NULL,
	FoodName varchar(30) NOT NULL,
	FoodPrice double(4,2) NOT NULL,
	PRIMARY KEY (FoodID)
);

CREATE TABLE tables (
	TableID int(3) NOT NULL,
	Chairs int(2) NOT NULL,
	Status varchar(20) NOT NULL,
	PRIMARY KEY (TableID)
);

CREATE TABLE orders (
	OrderID int(3) NOT NULL AUTO_INCREMENT,
	OrderDate date NOT NULL,
	OrderTime time NOT NULL,
	TableID int(3) NOT NULL,
	PaidStatus boolean NOT NULL,
	FOREIGN KEY(TableID) REFERENCES Tables(TableID),
	PRIMARY KEY (OrderID)
);

CREATE TABLE orderpayment (
	OrderID int(3) NOT NULL,
	TotalPrice double(6,2) NOT NULL,
	TotalPaid double(6,2) NOT NULL,
	Balance double(6,2) NOT NULL,
	DatePaid date NOT NULL,
	FOREIGN KEY(OrderID) REFERENCES Orders(OrderID),
	PRIMARY KEY (OrderID)
);

CREATE TABLE orderdetails (
	OrderID int(3) NOT NULL,
	FoodID varchar(3) NOT NULL,
	Quantity int(3) NOT NULL,
	Total double(6,2) NOT NULL,
	FOREIGN KEY(FoodID) REFERENCES Menu(FoodID),
	FOREIGN KEY(OrderID) REFERENCES Orders(OrderID),
	PRIMARY KEY (OrderID, FoodID)
);



