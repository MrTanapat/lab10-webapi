<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Products</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <h1>Products</h1>

    <button id="openModal" class="add">Add Product</button>
    <input type="text" id="search" placeholder="Search product..." class="search">

    <div id="products"></div>
    <div id="pagination"></div>

    <div id="productModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add / Update Product</h2>
        <form id="productForm">
          <input type="hidden" id="productId">
          <input type="text" id="name" placeholder="Name" required>
          <input type="text" id="brand" placeholder="Brand" required>
          <input type="number" id="price" placeholder="Price" required>
          <input type="number" id="stock" placeholder="Stock" required>
          <input type="text" id="description" placeholder="Description">
          <input type="text" id="image_url" placeholder="Image URL">
          <button type="submit" class="add">Save Product</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    const apiURL = "http://localhost/lab10-webapi/api.php";
    let allProducts = [];
    let currentPage = 1;
    const itemsPerPage = 6;

    const modal = document.getElementById("productModal");
    const btnOpen = document.getElementById("openModal");
    const spanClose = document.querySelector(".close");

    btnOpen.onclick = () => {
      modal.style.display = "block";
      document.getElementById("productForm").reset();
      document.getElementById("productId").value = "";
    };
    spanClose.onclick = () => modal.style.display = "none";
    window.onclick = e => {
      if (e.target === modal) modal.style.display = "none";
    };

    function fetchProducts() {
      fetch(apiURL)
        .then(res => res.json())
        .then(data => {
          allProducts = data;
          renderProducts();
          renderPagination();
        });
    }

    function renderProducts() {
      const container = document.getElementById("products");
      container.innerHTML = "";

      const searchQuery = document.getElementById("search").value.toLowerCase();
      const filtered = allProducts.filter(p => p.name.toLowerCase().includes(searchQuery));

      const start = (currentPage - 1) * itemsPerPage;
      const paginated = filtered.slice(start, start + itemsPerPage);

      paginated.forEach(p => {
        const div = document.createElement("div");
        div.className = "product";
        div.innerHTML = `
          <div>
            <h3>${p.name}</h3>
            <p>Brand: ${p.brand}</p>
            <p>Price: ${p.price}</p>
            <p>Stock: ${p.stock}</p>
          </div>
          <div>
            <button class="edit" onclick="editProduct(${p.id})">Edit</button>
            <button class="delete" onclick="deleteProduct(${p.id})">Delete</button>
          </div>
        `;
        container.appendChild(div);
      });
    }

    function renderPagination() {
      const pagination = document.getElementById("pagination");
      pagination.innerHTML = "";

      const searchQuery = document.getElementById("search").value.toLowerCase();
      const filtered = allProducts.filter(p => p.name.toLowerCase().includes(searchQuery));
      const totalPages = Math.ceil(filtered.length / itemsPerPage);

      for (let i = 1; i <= totalPages; i++) {
        const btn = document.createElement("button");
        btn.textContent = i;
        if (i === currentPage) btn.style.fontWeight = "bold";
        btn.onclick = () => {
          currentPage = i;
          renderProducts();
          renderPagination();
        };
        pagination.appendChild(btn);
      }
    }

    document.getElementById("search").addEventListener("input", () => {
      currentPage = 1;
      renderProducts();
      renderPagination();
    });

    function editProduct(id) {
      fetch(`${apiURL}?id=${id}`)
        .then(res => res.json())
        .then(p => {
          document.getElementById("productId").value = p.id;
          document.getElementById("name").value = p.name;
          document.getElementById("brand").value = p.brand;
          document.getElementById("price").value = p.price;
          document.getElementById("stock").value = p.stock;
          document.getElementById("description").value = p.description;
          document.getElementById("image_url").value = p.image_url;
          modal.style.display = "block";
        });
    }

    function deleteProduct(id) {
      if (confirm("Delete this product?")) {
        fetch(`${apiURL}?id=${id}`, {
            method: "DELETE"
          })
          .then(res => res.json())
          .then(() => fetchProducts());
      }
    }

    document.getElementById("productForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const id = document.getElementById("productId").value;
      const product = {
        name: document.getElementById("name").value,
        brand: document.getElementById("brand").value,
        price: document.getElementById("price").value,
        stock: document.getElementById("stock").value,
        description: document.getElementById("description").value,
        image_url: document.getElementById("image_url").value
      };
      const method = id ? "PUT" : "POST";
      const url = id ? `${apiURL}?id=${id}` : apiURL;

      fetch(url, {
          method: method,
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(product)
        }).then(res => res.json())
        .then(() => {
          fetchProducts();
          modal.style.display = "none";
        });
    });

    fetchProducts();
  </script>
</body>

</html>