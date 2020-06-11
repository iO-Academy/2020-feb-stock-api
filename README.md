# Warehouse API

A warehouse house built by Mayden Academy students that would help employees keep tracking and maintain their stock.

[For information on how to set up this API for development click here!](setup.md)

**Requests:**

* ***Products***
  * [Add a product](#add-a-product)
  * [Edit a product](#edit-a-product)
  * [Get all products](#get-all-product)
  * [Delete a product](#delete-a-product)
  * [Get specified product](#get-specified-product)
  * [Edit stock level](#edit-a-product's-stock-level)
  * [Reinstate a deleted product](#reinstate-a-deleted-product)
  
* ***Orders***
  * [Add an order](#add-an-order)
  * [Get all orders](#get-all-orders)
  * [Cancel an order](#cancel-an-order)
  * [Mark an order complete](#mark-an-order-complete)
 

 ***
 

# Add a product
----
  Add a product to in order to keep track of it.

* **URL**

  /products

* **Method:**
 
   `POST`
 
* **Request Body**

```json
{
    "product": {
    	"sku" : "UGG-BB-PNR-98",
        "name": "Harry Potter 16",
        "price": "99.99",
        "stockLevel": "100"
    }
}
```

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


# Edit a product
----
  Edit an existing product.

* **URL**

  /products/{sku}

* **Method:**

   `PUT`
    
* **Request Body**

```json
{
    "product": {
        "name": "Harry Potter 99",
        "price": "15",
        "stockLevel": "5"
    }
}
```

* **Success Response:**
 
  * **Code:** 200 <br />
 **Content:** `{ success : true, message: "Product successfully updated", data: [] }`
 
* **Error Response:**

  * **Code:** 400 UNAUTHORIZED <br />
 **Content:** `{ success : false, message: "Invalid request", data: [] }`
    
    or 
    
  * **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
  
# Get all products
----
  Get all products in the database.

* **URL**

  /products

* **Method:**

   `GET`

* **Success Response:**
 
  * **Code:** 200 <br />
 **Content:** 
 ```json
 {
     "success": true,
     "message": "All products returned",
     "data": {
         "products": [
             {
                 "sku": "abcdef123456",
                 "name": "test_name_1",
                 "price": "99.99",
                 "stockLevel": "1"
             },
             {
                 "sku": "abcdef123457",
                 "name": "test_name_2",
                 "price": "89.99",
                 "stockLevel": "5"
             },
             {
                 "sku": "abcdef123458",
                 "name": "test_name_3",
                 "price": "79.99",
                 "stockLevel": "10"
             }
         ]
     }
 }
 ```
 
* **Error Response:**
    
  * **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
  
# Delete a product
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


# Get specified product
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
  
 
# Edit a product's stock level
----
  Edit an existing product.

* **URL**

  /products/stock/{sku}

* **Method:**

   `PUT`
   
* **Request Body**

```json
{
    "product": {
        "stockLevel": "28"
    }
}
```

* **Success Response:**
 
  * **Code:** 200 <br />
  **Content:** `{ success : true, message: "Stock level successfully updated", data: [] }`

 
* **Error Response:**

  * **Code:** 400 UNAUTHORIZED <br />
  **Content:** `{ success : false, message: "Invalid Stock Level", data: [] }`
    
    or 
    
  **Code:** 500 Server Error <br />
  **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
  
# Reinstate a deleted product
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
  
 ***
 **Orders**
 
 # Add an order
 ----

    Add an order to the database.
  
 * **URL**
  
    /orders
  
 * **Method:**
   
     `POST`
   
 * **Request Body**

```json
{
    "order": {
        "orderNumber": "K3FFDGJUDFP",
        "customerEmail": "example@mail.com",
        "shippingAddress1": "New Street 15",
		"shippingAddress2": "",
        "shippingCity": "Bath",
        "shippingPostcode": "BA91LO",
        "shippingCountry": "UK",
        "products": [
            {
                "sku": "abcdef123456",
                "volumeOrdered": 1
            },
            {
                "sku": "abcdef123457",
                "volumeOrdered": 2
            }
        ]
    }
}
```
        
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
    
   
  
# Get all orders
----

    By default, gets all active orders that are in the database.
  
* **URL**
  
    /orders
  
* **Method:**
   
     `GET`

*  **URL Params**

    If you would like to see completed orders.
    
   **Optional:**
 
   `completed=1` 
        
* **Success Response:**
   
    * **Code:** 200 <br />
   **Content:**  
```json
{
    "succcess": true,
    "message": "Orders successfully returned",
    "data": {
        "orders": [
            {
                "orderNumber": "K3FK57MN",
                "customerEmail": "example@mail.com",
                "shippingAddress1": "New Street 15",
                "shippingAddress2": "optional",
                "shippingCity": "Bath",
                "shippingPostcode": "BA91LO",
                "shippingCountry": "UK",
                "products": [
                    {
                        "sku": "UGG-BB-PNR-98",
                        "volumeOrdered": 5
                    },
                    {
                        "sku": "BNH-LR-DSR-54",
                        "volumeOrdered": 9
                    }
                ]
            },
            {
                "orderNumber": "F87MKNAL",
                "customerEmail": "anotheremail@gmail.com",
                "shippingAddress1": "Another Lane 56",
                "shippingAddress2": "Flat 2B",
                "shippingCity": "Bristol",
                "shippingPostcode": "BR56LM",
                "shippingCountry": "UK",
                "products": [
                    {
                        "sku": "BJL-44-NMR-78",
                        "volumeOrdered": 1
                    },
                    {
                        "sku": "JKS-89-PMJ-40",
                        "volumeOrdered": 3
                    }
                ]
            }
        ]
    }
}
 ```
   
* **Error Response:**
 
    * **Code:** 500 Internal Server Error <br />
        **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
   
   
 # Cancel an order
 ----
    
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
    
    
 # Mark an order complete
 ----
    
  Complete an active order from the database
      
 * **URL**
      
     /orders/complete/{orderNumber}
      
 * **Method:**
       
      `PUT`
       
            
* **Success Response:**
       
    * **Code:** 200 <br />
       **Content:** `{ success : true, message: "Order successfully marked completed", data: []}`
       
* **Error Response:**
   * **Code:** 400 User Error <br />
        **Content:** `{ success : false, message: "No order exists with provided order number", data: [] }`
      
      or
     
   * **Code:** 500 Internal Server Error <br />
    **Content:** `{ success : false, message: "Something went wrong, please try again later", data: [] }`
        
