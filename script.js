function showSection(sectionId) {
  // Hide all sections
  document.querySelectorAll("section").forEach((section) => {
    section.classList.add("hidden");
  });

  // Show the selected section
  document.getElementById(sectionId).classList.remove("hidden");
}

function searchBook() {
  const query = document.getElementById("searchInput").value;
  fetch(`search_book.php?q=${query}`)
    .then((response) => response.json())
    .then((data) => {
      const resultsDiv = document.getElementById("searchResults");
      resultsDiv.innerHTML = data
        .map((book) => `<p>${book.title} by ${book.author}</p>`)
        .join("");
    });
}

function borrowBook() {
  const bookId = document.getElementById("borrowBookId").value;
  const studentId = document.getElementById("borrowStudentId").value;

  fetch("borrow.php", {
    method: "POST",
    body: new URLSearchParams({
      book_id: bookId,
      student_id: studentId,
    }),
  })
    .then((response) => response.text())
    .then((message) => alert(message));
}

function returnBook() {
  const bookId = document.getElementById("returnBookId").value;
  const studentId = document.getElementById("returnStudentId").value;

  fetch("return.php", {
    method: "POST",
    body: new URLSearchParams({
      book_id: bookId,
      student_id: studentId,
    }),
  })
    .then((response) => response.text())
    .then((message) => alert(message));
}

function viewHistory() {
  const studentId = document.getElementById("historyStudentId").value;
  fetch(`history.php?student_id=${studentId}`)
    .then((response) => response.json())
    .then((data) => {
      const historyDiv = document.getElementById("historyResults");
      historyDiv.innerHTML = data
        .map(
          (entry) =>
            `<p>${entry.book_title} - Borrowed on: ${entry.borrow_date}</p>`
        )
        .join("");
    });
}
