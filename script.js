// Import jQuery
const $ = require("jquery")

$(document).ready(() => {
  // AJAX setup
  $.ajaxSetup({
    beforeSend: () => {
      $(".loading").show()
    },
    complete: () => {
      $(".loading").hide()
    },
  })

  // Registration form
  $("#registerForm").on("submit", (e) => {
    e.preventDefault()

    const formData = {
      name: $("#name").val(),
      email: $("#email").val(),
      password: $("#password").val(),
      confirm_password: $("#confirm_password").val(),
      phone: $("#phone").val(),
      address: $("#address").val(),
      linkedin: $("#linkedin").val(),
    }

    $.ajax({
      url: "ajax/register.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showMessage("Registration successful! Redirecting to login...", "success")
          setTimeout(() => {
            window.location.href = "login.php"
          }, 2000)
        } else {
          showMessage(response.message, "error")
        }
      },
      error: () => {
        showMessage("An error occurred. Please try again.", "error")
      },
    })
  })

  // Login form
  $("#loginForm").on("submit", (e) => {
    e.preventDefault()

    const formData = {
      email: $("#email").val(),
      password: $("#password").val(),
    }

    $.ajax({
      url: "ajax/login.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showMessage("Login successful! Redirecting...", "success")
          setTimeout(() => {
            window.location.href = "dashboard.php"
          }, 1500)
        } else {
          showMessage(response.message, "error")
        }
      },
      error: () => {
        showMessage("An error occurred. Please try again.", "error")
      },
    })
  })

  // Profile update
  $("#profileForm").on("submit", function (e) {
    e.preventDefault()

    const formData = $(this).serialize()

    $.ajax({
      url: "ajax/update_profile.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showMessage("Profile updated successfully!", "success")
        } else {
          showMessage(response.message, "error")
        }
      },
      error: () => {
        showMessage("An error occurred. Please try again.", "error")
      },
    })
  })

  // Add education
  $("#addEducationForm").on("submit", function (e) {
    e.preventDefault()

    const formData = $(this).serialize()

    $.ajax({
      url: "ajax/add_education.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showMessage("Education added successfully!", "success")
          $("#addEducationModal").hide()
          loadEducation()
          $("#addEducationForm")[0].reset()
        } else {
          showMessage(response.message, "error")
        }
      },
    })
  })

  // Add project
  $("#addProjectForm").on("submit", function (e) {
    e.preventDefault()

    const formData = $(this).serialize()

    $.ajax({
      url: "ajax/add_project.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showMessage("Project added successfully!", "success")
          $("#addProjectModal").hide()
          loadProjects()
          $("#addProjectForm")[0].reset()
        } else {
          showMessage(response.message, "error")
        }
      },
    })
  })

  // Add skill
  $("#addSkillForm").on("submit", (e) => {
    e.preventDefault()

    const skill = $("#skill_name").val()

    $.ajax({
      url: "ajax/add_skill.php",
      type: "POST",
      data: { skill_name: skill },
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showMessage("Skill added successfully!", "success")
          loadSkills()
          $("#skill_name").val("")
        } else {
          showMessage(response.message, "error")
        }
      },
    })
  })

  // Contact form
  $("#contactForm").on("submit", function (e) {
    e.preventDefault()

    const formData = $(this).serialize()

    $.ajax({
      url: "ajax/send_message.php",
      type: "POST",
      data: formData,
      dataType: "json",
      success: (response) => {
        if (response.success) {
          showMessage("Message sent successfully!", "success")
          $("#contactForm")[0].reset()
        } else {
          showMessage(response.message, "error")
        }
      },
    })
  })

  // Search and filter portfolios
  $("#searchInput, #skillFilter, #educationFilter").on("input change", () => {
    filterPortfolios()
  })

  // Modal controls
  $(".modal-trigger").on("click", function () {
    const modalId = $(this).data("modal")
    $("#" + modalId).show()
  })

  $(".close, .modal").on("click", function (e) {
    if (e.target === this) {
      $(".modal").hide()
    }
  })

  // Delete functions
  $(document).on("click", ".delete-btn", function () {
    const type = $(this).data("type")
    const id = $(this).data("id")

    if (confirm("Are you sure you want to delete this item?")) {
      $.ajax({
        url: "ajax/delete_item.php",
        type: "POST",
        data: { type: type, id: id },
        dataType: "json",
        success: (response) => {
          if (response.success) {
            showMessage("Item deleted successfully!", "success")
            // Reload the appropriate section
            switch (type) {
              case "education":
                loadEducation()
                break
              case "project":
                loadProjects()
                break
              case "skill":
                loadSkills()
                break
              case "certification":
                loadCertifications()
                break
              case "language":
                loadLanguages()
                break
              case "hobby":
                loadHobbies()
                break
            }
          } else {
            showMessage(response.message, "error")
          }
        },
      })
    }
  })

  // Load dashboard data
  if ($("#dashboard").length) {
    loadEducation()
    loadProjects()
    loadSkills()
    loadCertifications()
    loadLanguages()
    loadHobbies()
  }
})

// Helper functions
function showMessage(message, type) {
  const messageDiv = $(".message")
  messageDiv.removeClass("success error").addClass(type)
  messageDiv.text(message).show()

  setTimeout(() => {
    messageDiv.hide()
  }, 5000)
}

function loadEducation() {
  $.ajax({
    url: "ajax/get_education.php",
    type: "GET",
    dataType: "json",
    success: (data) => {
      let html = ""
      if (data.length > 0) {
        html =
          '<table class="data-table"><thead><tr><th>Level</th><th>Institute</th><th>Year</th><th>Score</th><th>Actions</th></tr></thead><tbody>'
        data.forEach((item) => {
          html += `<tr>
                        <td>${item.level}</td>
                        <td>${item.institute}</td>
                        <td>${item.year}</td>
                        <td>${item.score || "N/A"}</td>
                        <td><button class="btn btn-sm delete-btn" data-type="education" data-id="${item.id}">Delete</button></td>
                    </tr>`
        })
        html += "</tbody></table>"
      } else {
        html = "<p>No education records found.</p>"
      }
      $("#educationList").html(html)
    },
  })
}

function loadProjects() {
  $.ajax({
    url: "ajax/get_projects.php",
    type: "GET",
    dataType: "json",
    success: (data) => {
      let html = ""
      if (data.length > 0) {
        data.forEach((item) => {
          html += `<div class="card">
                        <h4>${item.title}</h4>
                        <p><strong>Languages:</strong> ${item.language_used || "N/A"}</p>
                        <p><strong>Libraries:</strong> ${item.libraries_used || "N/A"}</p>
                        <p><strong>Model:</strong> ${item.model_used || "N/A"}</p>
                        <p><strong>Description:</strong> ${item.description || "N/A"}</p>
                        <p><strong>Date:</strong> ${item.project_date || "N/A"}</p>
                        <button class="btn btn-sm delete-btn" data-type="project" data-id="${item.id}">Delete</button>
                    </div>`
        })
      } else {
        html = "<p>No projects found.</p>"
      }
      $("#projectsList").html(html)
    },
  })
}

function loadSkills() {
  $.ajax({
    url: "ajax/get_skills.php",
    type: "GET",
    dataType: "json",
    success: (data) => {
      let html = ""
      if (data.length > 0) {
        data.forEach((item) => {
          html += `<span class="skill-tag">${item.skill_name} <button class="delete-btn" data-type="skill" data-id="${item.id}">×</button></span>`
        })
      } else {
        html = "<p>No skills found.</p>"
      }
      $("#skillsList").html(html)
    },
  })
}

function loadCertifications() {
  $.ajax({
    url: "ajax/get_certifications.php",
    type: "GET",
    dataType: "json",
    success: (data) => {
      let html = ""
      if (data.length > 0) {
        html =
          '<table class="data-table"><thead><tr><th>Name</th><th>Organization</th><th>Date</th><th>Actions</th></tr></thead><tbody>'
        data.forEach((item) => {
          html += `<tr>
                        <td>${item.name}</td>
                        <td>${item.issuing_organization || "N/A"}</td>
                        <td>${item.issue_date || "N/A"}</td>
                        <td><button class="btn btn-sm delete-btn" data-type="certification" data-id="${item.id}">Delete</button></td>
                    </tr>`
        })
        html += "</tbody></table>"
      } else {
        html = "<p>No certifications found.</p>"
      }
      $("#certificationsList").html(html)
    },
  })
}

function loadLanguages() {
  $.ajax({
    url: "ajax/get_languages.php",
    type: "GET",
    dataType: "json",
    success: (data) => {
      let html = ""
      if (data.length > 0) {
        data.forEach((item) => {
          html += `<span class="skill-tag">${item.language} <button class="delete-btn" data-type="language" data-id="${item.id}">×</button></span>`
        })
      } else {
        html = "<p>No languages found.</p>"
      }
      $("#languagesList").html(html)
    },
  })
}

function loadHobbies() {
  $.ajax({
    url: "ajax/get_hobbies.php",
    type: "GET",
    dataType: "json",
    success: (data) => {
      let html = ""
      if (data.length > 0) {
        data.forEach((item) => {
          html += `<span class="skill-tag">${item.hobby} <button class="delete-btn" data-type="hobby" data-id="${item.id}">×</button></span>`
        })
      } else {
        html = "<p>No hobbies found.</p>"
      }
      $("#hobbiesList").html(html)
    },
  })
}

function filterPortfolios() {
  const search = $("#searchInput").val().toLowerCase()
  const skillFilter = $("#skillFilter").val()
  const educationFilter = $("#educationFilter").val()

  $(".portfolio-card").each(function () {
    const card = $(this)
    const name = card.find("h3").text().toLowerCase()
    const skills = card.data("skills") || ""
    const education = card.data("education") || ""

    let show = true

    if (search && !name.includes(search)) {
      show = false
    }

    if (skillFilter && !skills.includes(skillFilter)) {
      show = false
    }

    if (educationFilter && !education.includes(educationFilter)) {
      show = false
    }

    card.toggle(show)
  })
}
