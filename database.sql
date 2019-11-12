CREATE DATABASE restaurantdatabase;

CREATE TABLE account (
  Username varchar(20) NOT NULL,
  Password varchar(20) NOT NULL,
  AdminPrivilege boolean NOT NULL,
  PRIMARY KEY (Username)
);

INSERT INTO account (Username, Password, AdminPrivilege)
VALUES ('admin', 'admin', TRUE),
('user', 'user', FALSE);

CREATE TABLE menu (
	FoodID varchar(3) NOT NULL,
	FoodName varchar(30) NOT NULL,
	FoodPrice double(4,2) NOT NULL,
	PRIMARY KEY (FoodID)
);

INSERT INTO menu (FoodID, FoodName, FoodPrice)
VALUES ('f1', 'Lobster Benedict', 55.00),
('f2', 'Croque Madame', 23.00),
('f3', 'Angus Beef Burger', 60.00),
('f4', 'Trufle Mushroom Potato Hash', 20.00),
('f5', 'Tamarind Prawn Toast', 28.00),
('f6', 'Orange Duck Sausages', 30.00),
('f7', 'Hanged Caciocavallo', 35.00),
('f8', 'Greek Doughnut Twist with Nutella', 20.00),
('f9', 'Raspberry Ricotta Hotcakes', 35.00),
('f10', 'Lemon Myrtle Kombucha', 10.00),
('f11', 'Mule-Tide', 12.00),
('f12', 'Bounty Monarch Hot Chocolate',15.00),
('f13', 'LoupTown Earl Grey Tea', 10.00);


CREATE TABLE tables (
	TableID int(3) NOT NULL,
	Chairs int(2) NOT NULL,
	Status varchar(20) NOT NULL,
	check(Status in ('available', 'reserved', 'occupied')),
	PRIMARY KEY (TableID)
);

INSERT INTO tables (TableID, Chairs, Status)
VALUES (1, 8, 'available'),
(2, 8, 'available'),
(3, 8, 'available'),
(4, 8, 'available'),
(5, 8, 'available'),
(6, 8, 'available');

CREATE TABLE orders (
	OrderID int(3) NOT NULL AUTO_INCREMENT,
	OrderDate date NOT NULL,
	OrderTime time NOT NULL,
	TableID int(3) NOT NULL,
	FOREIGN KEY(TableID) REFERENCES tables(TableID),
	PRIMARY KEY (OrderID)
);

INSERT INTO orders (OrderDate, OrderTime, TableID)


CREATE TABLE orderpayment (
	OrderID int(3) NOT NULL,
	TotalPrice double(6,2) NOT NULL,
	DiscountPrice double(6,2),
	TotalPaid double(6,2),
	Balance double(6,2),
	PaidStatus boolean NOT NULL,
	FOREIGN KEY(OrderID) REFERENCES orders(OrderID),
	PRIMARY KEY (OrderID)
);

INSERT INTO orderpayment (OrderID, TotalPrice, DiscountPrice, TotalPaid, Balance, PaidStatus)

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

CREATE TABLE reservation (
	ReservationID int(3) NOT NULL AUTO_INCREMENT,
	TableID int(3) NOT NULL,
	ReservationTime time NOT NULL,
	ReservationDate date NOT NULL,
	EndTime time NOT NULL,
	FOREIGN KEY(TableID) REFERENCES tables(TableID),
	PRIMARY KEY(ReservationID, TableID)
);

INSERT INTO reservation (TableID, ReservationDate, ReservationTime, EndTime)
VALUES (1,'2019-10-09', '07:07:07', '19:09:09');

CREATE TABLE coupons (
	CouponCode varchar(10) NOT NULL,
	DiscountRate double(3,2) NOT NULL,
	ExpiryDate date,
	PRIMARY KEY(CouponCode)
);

INSERT INTO coupons (CouponCode, DiscountRate, ExpiryDate)
VALUES ('testcode','0.50', '2020-12-30');
