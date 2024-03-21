document.getElementById("loanForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    // Get values from form inputs
    var income = parseFloat(document.getElementById("income").value);
    var expenditure = parseFloat(document.getElementById("expenditure").value);

    // Check if expenditure is higher than income
    if (expenditure > income) {
        // Show error message
        document.getElementById("result").innerHTML = "<p>Error: Higher Income Expenditure. You are ineligible for a loan at the moment.</p>";
    } else {
        // Calculate loan amount (Example: 80% of income)
        var loanAmount = 0.8 * income; // You can adjust the calculation based on your requirements

        // Show loan eligibility message
        document.getElementById("result").innerHTML = "<p>Based on your income and expenditure, you are eligible to borrow up to $" + loanAmount.toFixed(2) + ".</p>";
    }
});
