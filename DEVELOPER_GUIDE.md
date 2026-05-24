# 🔧 Developer Guide - Extending Silo System

## 📚 Table of Contents
1. [Quick Start](#quick-start)
2. [Adding New Divisions](#adding-new-divisions)
3. [Modifying Existing Forms](#modifying-existing-forms)
4. [Custom Validation](#custom-validation)
5. [Styling Custom Forms](#styling-custom-forms)
6. [Testing Your Changes](#testing-your-changes)
7. [Troubleshooting](#troubleshooting)

---

## 🚀 Quick Start

### Understanding the Current Structure

The Silo System works by checking the `currentGroup` value and rendering different forms accordingly:

```javascript
// In group.blade.php - DOMContentLoaded
if (customGroup) {
  // Custom groups created by users
  renderCustomGroupForm(customGroup);
} else if (currentGroup === "Admin") {
  // Admin division form
  renderAdminForm();
} else if (currentGroup === "Web Developer") {
  // Web developer division form
  renderWebDevForm();
} else if (currentGroup === "Designer") {
  // Designer division form
  renderDesignerForm();
} else {
  // Generic form for other groups
  renderGenericForm();
}
```

---

## ➕ Adding New Divisions

### Step 1: Add Form HTML

Add a new `else if` block in the DOMContentLoaded event:

```javascript
} else if (currentGroup === "Your Division Name") {
  postBox.innerHTML = `
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                padding: 20px; border-radius: 10px; margin-bottom: 20px; color: white;">
      <h3 style="margin: 0; font-size: 16px; font-weight: 600;">
        📋 Formulir Your Division Name
      </h3>
      <p style="margin: 5px 0 0 0; font-size: 13px; opacity: 0.9;">
        Description of your division form
      </p>
    </div>

    <!-- Your form fields here -->
    <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
      <label style="display:block; font-size: 12px; font-weight: 600; 
                    margin-bottom: 8px; color: #1877f2; text-transform: uppercase;">
        📌 SECTION TITLE
      </label>
      
      <div style="margin-bottom: 12px;">
        <label style="display:block; font-size: 12px; margin-bottom: 4px; 
                      color: #65676b; font-weight: 500;">Field Label</label>
        <input type="text" id="yourFieldId" placeholder="Placeholder text" 
               style="width: 100%; padding: 10px; border-radius: 5px; 
                      border: 1px solid #ddd; font-size: 14px; margin-bottom: 8px;">
      </div>
    </div>

    <button onclick="addYourDivisionPost()" 
            style="width: 100%; padding: 14px 16px; 
                   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                   color: white; border: none; border-radius: 6px; 
                   font-weight: 600; cursor: pointer; font-size: 15px;">
      ✅ Post Your Division
    </button>
  `;
}
```

### Step 2: Add Submission Function

Add a new function to handle the submission:

```javascript
function addYourDivisionPost() {
  // 1. Get form values
  let field1 = document.getElementById("yourFieldId").value.trim();
  let field2 = document.getElementById("anotherFieldId").value;
  
  // 2. Validate
  if (!field1 || !field2) {
    alert("⚠️ Mohon lengkapi semua field yang wajib diisi!");
    return;
  }
  
  // 3. Format data
  let structuredText = `
    <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                padding: 2px; border-radius: 10px; margin-bottom: 15px;">
      <div style="background: white; padding: 15px; border-radius: 8px;">
        <p style="margin: 0 0 12px 0; font-weight: 700; color: #667eea; 
                  font-size: 14px; text-transform: uppercase;">
          📋 Your Division Name
        </p>
        
        <div style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-bottom: 10px;">
          <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
              <td style="padding: 6px 0; color: #65676b; font-weight: 500; width: 140px;">
                📌 Field 1
              </td>
              <td style="padding: 6px 0; font-weight: 600; color: #1877f2;">
                ${field1}
              </td>
            </tr>
            <tr>
              <td style="padding: 6px 0; color: #65676b; font-weight: 500;">
                📌 Field 2
              </td>
              <td style="padding: 6px 0; font-weight: 600; color: #28a745;">
                ${field2}
              </td>
            </tr>
          </table>
        </div>

        <div style="border-top: 1px solid #e5e7eb; padding-top: 10px; 
                    font-size: 12px; color: #999;">
          ⏰ ${new Date().toLocaleString('id-ID')}
        </div>
      </div>
    </div>
  `;

  // 4. Save post
  saveStructuredPost(structuredText, null);
  
  // 5. Reset form
  document.getElementById("yourFieldId").value = "";
  document.getElementById("anotherFieldId").value = "";
}
```

---

## ✏️ Modifying Existing Forms

### Changing Field Options

**Example**: Update Admin service categories

**Current**:
```javascript
<select id="adminService" style="...">
  <option value="">Pilih Kategori Layanan</option>
  <option value="Web Developer">🌐 Web Developer</option>
  <option value="Design">🎨 Design</option>
  <option value="Content">📝 Content</option>
  <option value="SEO">🔍 SEO</option>
  <option value="Social Media">📱 Social Media</option>
</select>
```

**To Add New Option**:
```javascript
<select id="adminService" style="...">
  <option value="">Pilih Kategori Layanan</option>
  <option value="Web Developer">🌐 Web Developer</option>
  <option value="Design">🎨 Design</option>
  <option value="Content">📝 Content</option>
  <option value="SEO">🔍 SEO</option>
  <option value="Social Media">📱 Social Media</option>
  <option value="Brand Consulting">🎯 Brand Consulting</option>  <!-- NEW -->
</select>
```

### Adding New Input Fields

**Example**: Add Priority field to Admin form

```javascript
// In the section where you want to add it
<div style="margin-bottom: 12px;">
  <label style="display:block; font-size: 12px; margin-bottom: 4px; 
                color: #65676b; font-weight: 500;">
    Prioritas Proyek
  </label>
  <select id="adminPriority" style="width: 100%; padding: 10px; 
                                     border-radius: 5px; border: 1px solid #ddd; 
                                     font-size: 14px; margin-bottom: 8px;">
    <option value="">Pilih Prioritas</option>
    <option value="🔴 Urgent">🔴 Urgent</option>
    <option value="🟠 High">🟠 High</option>
    <option value="🟡 Medium">🟡 Medium</option>
    <option value="🟢 Low">🟢 Low</option>
  </select>
</div>

// Then update the addAdminPost function
function addAdminPost() {
  // ... existing code ...
  let priority = document.getElementById("adminPriority").value;
  
  // ... validation ...
  
  // Add to structured text
  // In the table, add:
  // <tr>
  //   <td>⚡ Prioritas</td>
  //   <td>${priority}</td>
  // </tr>
}
```

### Removing Fields

**Example**: Remove catatan field from Admin form

```javascript
// 1. Remove the HTML field from the form
<!-- DELETE THIS -->
<!-- <div style="margin-bottom: 12px;">
    <label>Catatan Khusus</label>
    <textarea id="adminNotes">...</textarea>
</div> -->

// 2. Remove from addAdminPost function
// let notes = document.getElementById("adminNotes").value.trim(); // REMOVE THIS

// 3. Remove from structured output
// ${notes ? `<tr>...</tr>` : ''} // REMOVE THIS

// 4. Remove from reset
// document.getElementById("adminNotes").value = ""; // REMOVE THIS
```

---

## 🔐 Custom Validation

### Basic Field Validation

```javascript
// Required field check
if (!fieldValue || fieldValue.trim() === "") {
  alert("⚠️ Field tidak boleh kosong!");
  return;
}

// Email validation
let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
if (!emailRegex.test(emailValue)) {
  alert("⚠️ Format email tidak valid!");
  return;
}

// URL validation
try {
  new URL(urlValue);
} catch (e) {
  alert("⚠️ URL tidak valid!");
  return;
}

// Number validation
if (isNaN(numberValue) || numberValue < 0) {
  alert("⚠️ Mohon masukkan angka yang valid!");
  return;
}
```

### Custom Validation Function

```javascript
function validateYourDivisionForm() {
  let errors = [];
  
  let field1 = document.getElementById("field1").value.trim();
  let field2 = document.getElementById("field2").value;
  
  // Field 1 checks
  if (!field1) {
    errors.push("Field 1 tidak boleh kosong");
  } else if (field1.length < 3) {
    errors.push("Field 1 harus minimal 3 karakter");
  } else if (field1.length > 50) {
    errors.push("Field 1 maksimal 50 karakter");
  }
  
  // Field 2 checks
  if (!field2) {
    errors.push("Field 2 harus dipilih");
  }
  
  // Return result
  if (errors.length > 0) {
    alert("⚠️ Errors:\n" + errors.join("\n"));
    return false;
  }
  
  return true;
}

// Usage in form submission
function addYourDivisionPost() {
  if (!validateYourDivisionForm()) {
    return;
  }
  
  // ... rest of submission code ...
}
```

### Conditional Validation

```javascript
function addYourDivisionPost() {
  let type = document.getElementById("typeField").value;
  let additionalField = document.getElementById("additionalField").value;
  
  // Only require additionalField if type is "custom"
  if (type === "custom" && !additionalField) {
    alert("⚠️ Mohon lengkapi field tambahan untuk tipe custom!");
    return;
  }
  
  // ... rest of code ...
}
```

---

## 🎨 Styling Custom Forms

### Color Scheme Template

```css
/* Pastikan warna section matches dengan tema */

/* Option 1: Blue Theme */
--primary-color: #1877f2;
--secondary-color: #0a66c2;
--background: #f0f2f5;
--section-color: #667eea;

/* Option 2: Green Theme */
--primary-color: #28a745;
--secondary-color: #218838;
--background: #f0f8f5;
--section-color: #28a745;

/* Option 3: Orange Theme */
--primary-color: #f39c12;
--secondary-color: #e67e22;
--background: #fff9f0;
--section-color: #f39c12;
```

### Form Section Template

```html
<div style="background: #f8f9fa; padding: 15px; border-radius: 8px; 
            margin-bottom: 15px; border-left: 4px solid YOUR_COLOR;">
  <label style="display:block; font-size: 12px; font-weight: 600; 
               margin-bottom: 8px; color: YOUR_COLOR; 
               text-transform: uppercase;">
    🎯 SECTION TITLE
  </label>
  
  <!-- Your fields here -->
</div>
```

### Gradient Button

```html
<button onclick="addYourPost()" 
        style="width: 100%; padding: 14px 16px; 
               background: linear-gradient(135deg, COLOR1 0%, COLOR2 100%); 
               color: white; border: none; border-radius: 6px; 
               font-weight: 600; cursor: pointer; font-size: 15px; 
               transition: all 0.3s ease;" 
        onmouseover="this.style.transform='translateY(-2px)'; 
                    this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'" 
        onmouseout="this.style.transform='translateY(0)'; 
                   this.style.boxShadow='none'">
  ✅ BUTTON TEXT
</button>
```

---

## 🧪 Testing Your Changes

### Manual Testing Checklist

- [ ] Form appears when clicking the division group
- [ ] All input fields are accessible and functional
- [ ] Required fields validation works
- [ ] Optional fields can be left blank
- [ ] File upload (if any) works correctly
- [ ] Dropdown options display correctly
- [ ] Date picker shows correct format
- [ ] Submit button is clickable
- [ ] Post appears in feed with correct formatting
- [ ] Form resets after submission
- [ ] Timestamps display correctly
- [ ] Responsive on mobile devices

### Testing Code Snippet

```javascript
// Open browser console (F12) and test:

// 1. Check if form renders
let form = document.getElementById("dynamicPostBox");
console.log(form.innerHTML); // Should contain your form fields

// 2. Check localStorage
let currentGroup = localStorage.getItem("currentGroup");
console.log("Current Group:", currentGroup);

// 3. Trigger validation manually
addYourDivisionPost(); // Should show error if fields empty

// 4. Check if post is saved
let allPosts = JSON.parse(localStorage.getItem("posts")) || [];
console.log("Total Posts:", allPosts.length);

// 5. Verify last post format
console.log("Last Post:", allPosts[allPosts.length - 1]);
```

---

## 🔍 Troubleshooting

### Form Not Appearing

**Problem**: Form tidak muncul ketika membuka grup

**Solutions**:
```javascript
// 1. Check current group
console.log(localStorage.getItem("currentGroup"));

// 2. Make sure group name matches exactly
// If group is "Admin", check for typo (case-sensitive)
if (currentGroup === "Admin") { // ✅ Correct
if (currentGroup === "admin") { // ❌ Wrong
if (currentGroup === " Admin") { // ❌ Wrong (space)

// 3. Clear cache and reload
localStorage.clear();
location.reload();

// 4. Check browser console for errors
// Press F12 to open DevTools
```

### Validation Not Working

**Problem**: Alert tidak muncul meskipun field kosong

**Solution**:
```javascript
// Make sure to return from function after showing error
function addYourDivisionPost() {
  if (!field1) {
    alert("Field required!");
    return; // ✅ Important!
  }
  
  // Rest of code
}
```

### Post Not Appearing in Feed

**Problem**: Submit berhasil tapi post tidak muncul

**Solutions**:
```javascript
// 1. Check saveStructuredPost function
// Make sure it's being called correctly
saveStructuredPost(structuredText, fileInput.files[0]);

// 2. Check localStorage posts
let posts = JSON.parse(localStorage.getItem("posts")) || [];
console.log(posts);

// 3. Check if postList element exists
let postList = document.getElementById("postList");
console.log(postList); // Should not be null

// 4. Manually render posts
// Check if the rendering function is being called
```

### Styling Issues

**Problem**: Style tidak terlihat atau tampilan aneh

**Solution**:
```javascript
// 1. Check inline styles are closed properly
// ❌ Wrong - Missing closing quote
<div style="color: red>

// ✅ Correct
<div style="color: red;">

// 2. Check CSS specificity
// If using external CSS, inline styles have higher priority

// 3. Use browser DevTools (F12)
// Inspect element to see applied styles
// Check for conflicting styles

// 4. Force refresh
// Clear cache: Ctrl+Shift+Delete
// Hard refresh: Ctrl+Shift+R
```

### File Upload Not Working

**Problem**: File tidak bisa diupload

**Solution**:
```javascript
// 1. Check file size
let fileInput = document.getElementById("fileInput");
console.log("File size:", fileInput.files[0].size);
console.log("Max size: 10485760 bytes (10MB)");

// 2. Check file type
console.log("File type:", fileInput.files[0].type);
// Valid types: application/pdf, application/msword, image/jpeg, etc.

// 3. Check if file input has accept attribute
// <input type="file" accept=".pdf,.doc,.jpg">

// 4. Verify file upload event listener
fileInput.addEventListener("change", function(e) {
  console.log("File selected:", e.target.files[0].name);
});
```

---

## 📞 Common Questions

### Q: Bagaimana cara menambah opsi dropdown dinamis?

**A**: Tambahkan ke array dan loop:
```javascript
let serviceOptions = ["Web Dev", "Design", "Content"];
let optionsHTML = serviceOptions.map(opt => 
  `<option>${opt}</option>`
).join('');

let selectHTML = `<select>${optionsHTML}</select>`;
```

### Q: Bagaimana cara menyimpan file upload ke server?

**A**: Saat ini files disimpan ke localStorage (client-side). Untuk server:
```javascript
// Gunakan FormData untuk multi-part upload
let formData = new FormData();
formData.append("file", fileInput.files[0]);
formData.append("userId", getUserId());

fetch("/api/upload", {
  method: "POST",
  body: formData
})
.then(response => response.json())
.then(data => console.log("Upload success:", data));
```

### Q: Bagaimana cara mereplikasi form ke divisi lain?

**A**: Copy-paste struktur dan ubah:
1. Group name check
2. Function names
3. Field IDs
4. Colors/styling
5. Submission handler

---

**Developer Guide Created**: 17 May 2025  
**Status**: ✅ Ready for Development
