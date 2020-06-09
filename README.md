# Warehouse API

A warehouse house built by Mayden Academy students that would help employees keep tracking and maintain their stock.

[For information on how to set up this API for development click here!](setup.md)


**Add a product**
----
  Add a product to in order to keep track of it.

* **URL**

  /products

* **Method:**
 
   `POST`
 
* **Data Params**

   **product** `{sku: "UGG-BB-PUR-06",name: "Harry Potter 15",price: "15.99", stockLevel: "15"}`

* **Success Response:**
 
  * **Code:** 200 <br />
 **Content:** `{ success : true, message: "Product successfully added", data: [] }`
 
* **Error Response:**

  * **Code:** 400 User Error <br />
  **Content:** `{ success : false, message: "Invalid Product Information", data: [] }`
      <br /> or <br />
   **Content:** `{ success : false, message: "Product SKU has previously been added ", data: {product: {sku: "UGG-BB-PUR-06", deleted: 1 or 0}} }` 
  
  or
  * **Code:** 500 Internal Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`


**Edit a product**
----
  Edit an existing product.

* **URL**

  /products/{sku}

* **Method:**

   `PUT`
    
* **Data Params**

   **product** `{sku: "UGG-BB-PNR-98",name: "Harry Potter 28",price: "14.99", stockLevel: "8"}`

* **Success Response:**
 
  * **Code:** 200 <br />
 **Content:** `{ success : true, message: "Product successfully updated", data: [] }`
 
* **Error Response:**

  * **Code:** 400 UNAUTHORIZED <br />
 **Content:** `{ success : false, message: "Invalid request", data: [] }`
    
    or 
    
  * **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
  
**Get all products**
----
  Get all products in the database.

* **URL**

  /products

* **Method:**

   `GET`

* **Success Response:**
 
  * **Code:** 200 <br />
 **Content:** `{ success : true, message: "All products returned", data: {products:[` <br />
            `{sku: "UGG-BB-PNR-98",name: "Harry Potter 28",price: "14.99", stockLevel: "8"},` <br />
            `{sku: "UGG-BB-PUR-06",name: "Harry Potter 15",price: "15.99", stockLevel: "15"}]} }`
 
* **Error Response:**
    
  * **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
  
**Delete a product**
----
  Delete an existing product.

* **URL**

  /products/{sku}

* **Method:**

   `DELETE`

* **Success Response:**
 
  * **Code:** 200 <br />
  **Content:** `{ success : true, message: "Product successfully deleted", data: [] }`
 
* **Error Response:**

  * **Code:** 400 UNAUTHORIZED <br />
 **Content:** `{ success : false, message: "Product does not exist", data: [] }`
 
 or
    
  * **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`


**Get specified product**
----
  Get a product in the database.

* **URL**

  /products/{sku}

* **Method:**

   `GET`

* **Success Response:**
 
  * **Code:** 200 <br />
  **Content:** `{ success : false, message: "Specified product returned", data: {product: {sku: "UGG-BB-PNR-98",name: "Harry Potter 28",price: "14.99", stockLevel: "8"}}}`

* **Error Response:**
    
  * **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
 
**Edit a product's stock level**
----
  Edit an existing product.

* **URL**

  /products/stock/{sku}

* **Method:**

   `PUT`
   
    
* **Data Params**

   **product** `{sku: "UGG-BB-PNR-98", stockLevel: "8"}`

* **Success Response:**
 
  * **Code:** 200 <br />
  **Content:** `{ success : true, message: "Stock level successfully updated", data: [] }`

 
* **Error Response:**

  * **Code:** 400 UNAUTHORIZED <br />
  **Content:** `{ success : false, message: "Invalid Stock Level", data: [] }`
    
    or 
    
  **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
**Reinstate a deleted product**
----
  Undo a delete on a previously deleted product

* **URL**

  /products/undodelete{sku}

* **Method:**

   `PUT`
    
* **Success Response:**
 
  * **Code:** 200 <br />
 **Content:** `{ success : true, message: "Product is no longer deleted", data: [] }`
 
* **Error Response:**

  * **Code:** 400 UNAUTHORIZED <br />
    **Content:** `{ success : false, message: "Invalid SKU", data: [] }`
     <br /> or <br />
    **Content:** `{ success : false, message: "Product SKU does not exist in DB ", data: []` 
    
    or 
    
  * **Code:** 500 Server Error <br />
    **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
  
 **Add an order**

    Add an order to the database.
  
 * **URL**
  
    /orders
  
 * **Method:**
   
     `POST`
   
 * **Data Params**
  
     **order** `{orderNumber: "K3FK57MN", customerEmail: "example@mail.com",` <br /> 
     `shippingAddress:` <br />
     `{address1: "New Street 15", address2: optional, city: "Bath", postcode: "BA91LO", country: "United Kingdom"}, ` <br /> 
     `products:[` <br />
                 `{sku: "BJL-44-NMR-78", "volumeOrdered" : 5},` <br />
                 `{sku: "JKS-89-PMJ-40", "volumeOrdered" : 1}` <br />
                 `]}`
        
 * **Success Response:**
   
    * **Code:** 200 <br />
   **Content:** `{ success : true, message: "Order successfully added", data: [] }`
   
 * **Error Response:**
  
    * **Code:** 400 User Error <br />
        **Content:** `{ success : false, message: "Invalid Order Information", data: [] }`
        <br /> or <br />
         **Content:** `{ success : false, message: "Order Number already exists ", data: []` 
    
    or
    * **Code:** 500 Internal Server Error <br />
        **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
    
   
  
**Get all orders**

    Get all orders that are in the database.
  
* **URL**
  
    /orders
  
* **Method:**
   
     `GET`
   
        
* **Success Response:**
   
    * **Code:** 200 <br />
   **Content:** `{ success : true, message: "Order successfully added", data: {orders:[` <br />
    `{orderNumber: "K3FK57MN", customerEmail: "example@mail.com",` <br /> 
         `shippingAddress:` <br />
         `{address1: "New Street 15", address2: optional, city: "Bath", postcode: "BA91LO", country: "United Kingdom"}, ` <br /> 
         `products:[` <br />
            `{sku: "UGG-BB-PNR-98", "volumeOrdered" : 2},` <br />
            `{sku: "UGG-BB-PUR-06","volumeOrdered" : 3}` <br />
            `]}` <br />
    `{orderNumber: "F87MKNAL", customerEmail: "another-email@mail.com",` <br /> 
         `shippingAddress:` <br />
         `{address1: "Another Street 28", address2: Flat 2E, city: "Bristol", postcode: "BR75ML", country: "United Kingdom"}, ` <br /> 
         `products:[` <br />
            `{sku: "BJL-44-NMR-78", "volumeOrdered" : 5},` <br />
            `{sku: "JKS-89-PMJ-40", "volumeOrdered" : 1}` <br />
            `]}`
   
* **Error Response:**
 
    * **Code:** 500 Internal Server Error <br />
        **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
   
   
 **Cancel an order**
    
  Cancel an order from the database
      
 * **URL**
      
     /orders/{orderNumber}
      
 * **Method:**
       
      `DELETE`
       
            
* **Success Response:**
       
    * **Code:** 200 <br />
       **Content:** `{ success : true, message: "Order successfully cancelled", data: []}`
       
* **Error Response:**
   * **Code:** 400 User Error <br />
        **Content:** `{ success : false, message: "No order exists with provided order number", data: [] }`
      
      or
     
   * **Code:** 500 Internal Server Error <br />
    **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
        