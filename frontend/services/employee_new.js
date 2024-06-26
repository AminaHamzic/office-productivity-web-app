var EmployeeService = {

    reload_employee_datatable: function () {
      Utils.get_datatable(
        "employees-table",
        Constants.API_BASE_URL + "employees",
        [
            { data: "user_id" },
            { data: "name_surname" },
            { data: "position" },
            { data: "office" },
            { data: "working_hours" },
            { data: "email"},
            { data: "action" }
        ]
    );
    },

    add_employee: function () {
      var form = $("#add-employee-form");
      if (form.valid()) {
        var data = Utils.serialize_form(form);
        RestClient.post(
          "employees/add",
          data,
          function (data) {
            EmployeeService.reload_employee_datatable();
            Utils.clear_form(form);
          },
          
        );
      }
    },
    
    open_edit_employee_modal: function (user_id) {

      RestClient.get("employees/" + user_id, function (data) {
        $('#update-id').val(data.user_id);
        $('#update-name_surname').val(data.name_surname);
        $('#update-position').val(data.position);
        $('#update-office').val(data.office);
        $('#update-working_hours').val(data.working_hours);
        $('#update-email').val(data.email);
        $('#update-password').val(data.password);
        $('#updateEmployeeModal').modal('show');
      });
    },
    
    save_employee_changes: function () {
      var form = $("#update-employee-form");
      if (form.valid()) {
          var data = Utils.serialize_form(form);
          var id = $('#update-id').val();
          //console.log("Data to be sent:", data);
  
          RestClient.put("employees/update/" + id, data, function(response) {
              //console.log("Response:", response);
              $('#updateEmployeeModal').modal('hide');
              EmployeeService.reload_employee_datatable();
              toastr.success("Employee updated successfully.");
          }, function(error) {
              console.log("Failed to update employee:", error.responseText);
              toastr.error("Error updating the employee.");
          });
      }
  },
  
   delete_employee: function (employee_id) {
      $('#deleteEmployeeModal').data('id', employee_id);
      $('#deleteEmployeeModal').modal('show');
  },

  confirm_delete_employee: function () {
      var employee_id = $('#deleteEmployeeModal').data('id');
      RestClient.delete(
          Constants.API_BASE_URL + "employee/delete/" + employee_id,
          {},
          function (response) {
              $('#deleteEmployeeModal').modal('hide');
              EmployeesService.reload_expense_datatable();
              toastr.success("Expense deleted successfully.");
          },
          function (error) {
              $('#deleteEmployeeModal').modal('hide');
              toastr.error("Error deleting the expense: " + error.responseText);
          }
      );
  }

  };


  