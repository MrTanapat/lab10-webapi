# Lab10 - Web API
## สร้างฐานข้อมูล MySQL
   - ตารางข้อมูล รองเท้า sneaker
    <img width="1200" height="600" alt="Screenshot 2025-10-03 092748" src="https://github.com/user-attachments/assets/8ef456be-dcb2-4332-a1c3-35fb30f84b7c" />

  - ตารางข้อมูลสินค้า (products)
    <img width="1200" height="600" alt="Screenshot 2025-10-03 095727" src="https://github.com/user-attachments/assets/e545dcb9-b1a4-4482-a019-8490afa612fd" />
---
## สร้างฐานข้อมูล MySQL
  - Web-api
  <img width="1200" height="600" alt="Screenshot 2025-10-03 125302" src="https://github.com/user-attachments/assets/64652bdf-5b72-4f3f-a31b-e258b500d106" />

---
## ผลลัพธ์ 
   - **ดูสินค้าทั้งหมด**
     ```
     GET http://localhost/lab10-WebAPI/api.php
     ```
     <img width="1200" height="600" alt="image" src="https://github.com/user-attachments/assets/7e97bd71-6e69-4757-9991-50af019c9b26" />

   - **ดูสินค้า 1 รายการ**  
     ```
     GET http://localhost/lab10-api/api.php?id=1
     ```
     <img width="1200" height="600" alt="image" src="https://github.com/user-attachments/assets/4cbe9757-8d61-4bb8-8224-68a9143f717f" />

   - **เพิ่มสินค้า (POST)**
     ```
     POST http://localhost/lab10-api/api.php
     ```
     
     ```json
     {
       "name": "Test Shoes",
       "brand": "TestBrand",
       "price": 1999,
       "stock": 5,
       "description": "รองเท้าทดสอบ",
       "image_url": "https://placehold.co/400x400/e74c3c/ffffff?text=Test+Shoes"
     }
     ```
     <img width="1200" height="600" alt="image" src="https://github.com/user-attachments/assets/7811f48b-ed12-49b3-ba11-69095c9c27bb" />

   - **แก้ไขสินค้า (PUT)**
     ```
     PUT http://localhost/lab10-api/api.php?id=1
     ```
     ```json
     {
       "name": "Updated Shoes",
       "brand": "NewBrand",
       "price": 2999,
       "stock": 10,
       "description": "แก้ไขแล้ว",
       "image_url": "https://placehold.co/400x400/e74c3c/ffffff?text=Updated Shoes"
     }
     ```
     <img width="1200" height="600" alt="image" src="https://github.com/user-attachments/assets/b224ef41-a54b-42e7-82cc-f1e25b2e85cb" />

     
   - **ลบสินค้า (DELETE)**  
     ```
     DELETE http://localhost/lab10-WebAPI/api.php?id=1
     ```
     <img width="1200" height="600" alt="image" src="https://github.com/user-attachments/assets/ec130f43-5855-4211-b89b-55cca820d074" />


---
