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

   **applicant** `{sku: "UGG-BB-PUR-06",name: "Harry Potter 15",price: "15.99", stockLevel: "15"}`

* **Success Response:**
 
  * **Code:** 200 <br />
    **success:** true <br />
 
* **Error Response:**

  * **Code:** 400 User Error <br />
    **Content:** `{ error : "SKU provided already exists in Database" }`


**Edit a product**
----
  Edit an existing product.

* **URL**

  /products/:sku

* **Method:**

   `PUT`
   
*  **URL Params**
 
   **Required:**
  
   `sku=[string]`
    
* **Data Params**

   **applicant** `{sku: "UGG-BB-PNR-98",name: "Harry Potter 28",price: "14.99", stockLevel: "8"}`

* **Success Response:**
 
  * **Code:** 200 <br />
    **success:** true <br />
 
* **Error Response:**

* **Code:** 400 UNAUTHORIZED <br />
  **Content:** `{ error : "Cannot make stock level negative" }`
    
    or 
    
  **Code:** 500 Server Error <br />
  **Content:** `{ error : "An unexpected error occured, please try again later" }`
  
  
**Get all products**
----
  Get all products in the database.

* **URL**

  /products

* **Method:**

   `GET`

* **Success Response:**
 
  * **Code:** 200 <br />
    **success:** true <br />
    **data:** `{products:[` <br />
     `{sku: "UGG-BB-PNR-98",name: "Harry Potter 28",price: "14.99", stockLevel: "8"},` <br />
    `{sku: "UGG-BB-PUR-06",name: "Harry Potter 15",price: "15.99", stockLevel: "15"}]}`
 
* **Error Response:**
    
  **Code:** 500 Server Error <br />
  **Content:** `{ error : "An unexpected error occured, please try again later" }`
  
  
**Delete a product**
----
  Delete an existing product.

* **URL**

  /products/:sku

* **Method:**

   `DELETE`
   
*  **URL Params**
 
   **Required:**
  
   `sku=[string]`

* **Success Response:**
 
  * **Code:** 200 <br />
    **success:** true <br />
 
* **Error Response:**
    
  **Code:** 500 Server Error <br />
  **Content:** `{ error : "An unexpected error occured, please try again later" }`


**Get specified product**
----
  Get a product in the database.

* **URL**

  /products/:sku

* **Method:**

   `GET`

*  **URL Params**
 
   **Required:**
  
   `sku=[string]`

* **Success Response:**
 
  * **Code:** 200 <br />
    **success:** true <br />
    **data:** `{sku: "UGG-BB-PNR-98",name: "Harry Potter 28",price: "14.99", stockLevel: "8"}`

* **Error Response:**
    
  **Code:** 500 Server Error <br />
  **Content:** `{ error : "An unexpected error occured, please try again later" }`
  
 
 
**Edit a product's stock level**
----
  Edit an existing product.

* **URL**

  /products/:sku

* **Method:**

   `PUT`
   
*  **URL Params**
 
   **Required:**
  
   `sku=[string]`
    
* **Data Params**

   **applicant** `{sku: "UGG-BB-PNR-98", stockLevel: "8"}`

* **Success Response:**
 
  * **Code:** 200 <br />
    **success:** true <br />
 
* **Error Response:**

* **Code:** 400 UNAUTHORIZED <br />
  **Content:** `{ error : "Cannot make stock level negative" }`
    
    or 
    
  **Code:** 500 Server Error <br />
  **Content:** `{ error : "An unexpected error occured, please try again later" }`
