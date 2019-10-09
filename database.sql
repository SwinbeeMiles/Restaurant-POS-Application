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

INSERT INTO menu (FoodID, FoodName, FoodPrice) 
VALUES ('f15', 'Fried Rice', 5.00);

CREATE TABLE tables (
	TableID int(3) NOT NULL,
	Chairs int(2) NOT NULL,
	Status varchar(20) NOT NULL,
	check(Status in ('available', 'reserved', 'occupied')),
	PRIMARY KEY (TableID)
);

INSERT INTO tables (TableID, Chairs, Status) 
VALUES (1, 8, 'available');

CREATE TABLE orders (
	OrderID int(3) NOT NULL AUTO_INCREMENT,
	OrderDate date NOT NULL,
	OrderTime time NOT NULL,
	TableID int(3) NOT NULL,
	FOREIGN KEY(TableID) REFERENCES tables(TableID),
	PRIMARY KEY (OrderID)
);

INSERT INTO orders (OrderDate, OrderTime, TableID) 
VALUES ('2019-10-09', '07:07:07', 1);

CREATE TABLE orderpayment (
	OrderID int(3) NOT NULL,
	TotalPrice double(6,2) NOT NULL,
	TotalPaid double(6,2),
	Balance double(6,2),
	PaidStatus boolean NOT NULL,
	FOREIGN KEY(OrderID) REFERENCES orders(OrderID),
	PRIMARY KEY (OrderID)
);

INSERT INTO orderpayment (OrderID, TotalPrice, TotalPaid, Balance, PaidStatus) 
VALUES (1,50.00,50.00,0.00,1);

CREATE TABLE orderdetails (
	OrderID int(3) NOT NULL,
	FoodID varchar(3) NOT NULL,
	Quantity int(3) NOT NULL,
	Total double(6,2) NOT NULL,
	FOREIGN KEY(FoodID) REFERENCES menu(FoodID),
	FOREIGN KEY(OrderID) REFERENCES orders(OrderID),
	PRIMARY KEY (OrderID, FoodID)
);

INSERT INTO orderdetails (OrderID, FoodID, Quantity, Total) 
VALUES (1,'f15',2,10.00);


