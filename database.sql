CREATE DATABASE RestaurantDatabase;

CREATE TABLE Account (
  Username varchar(20) NOT NULL,
  Password varchar(20) NOT NULL,
  AdminPrivilege boolean NOT NULL,
  PRIMARY KEY (Username)
);

INSERT INTO Account (Username, Password, AdminPrivilege) 
VALUES ('admin', 'admin', TRUE);

CREATE TABLE Menu (
	FoodID varchar(3) NOT NULL,
	FoodName varchar(30) NOT NULL,
	FoodPrice double(4,2) NOT NULL,
	PRIMARY KEY (FoodID)
);

CREATE TABLE Tables (
	TableID int(3) NOT NULL,
	Chairs int(2) NOT NULL,
	Status varchar(20) NOT NULL,
	PRIMARY KEY (TableID)
);

CREATE TABLE Orders (
	OrderID int(3) NOT NULL AUTO_INCREMENT,
	OrderDate date NOT NULL,
	OrderTime time NOT NULL,
	TableID int(3) NOT NULL,
	PaidStatus boolean NOT NULL,
	FOREIGN KEY(TableID) REFERENCES Tables(TableID),
	PRIMARY KEY (OrderID)
);

CREATE TABLE OrderPayment (
	OrderID int(3) NOT NULL,
	TotalPrice double(6,2) NOT NULL,
	TotalPaid double(6,2) NOT NULL,
	Balance double(6,2) NOT NULL,
	DatePaid date NOT NULL,
	FOREIGN KEY(OrderID) REFERENCES Orders(OrderID),
	PRIMARY KEY (OrderID)
);

CREATE TABLE OrderDetails (
	OrderID int(3) NOT NULL,
	FoodID varchar(3) NOT NULL,
	Quantity int(3) NOT NULL,
	Total double(6,2) NOT NULL,
	FOREIGN KEY(FoodID) REFERENCES Menu(FoodID),
	FOREIGN KEY(OrderID) REFERENCES Orders(OrderID),
	PRIMARY KEY (OrderID, FoodID)
);



