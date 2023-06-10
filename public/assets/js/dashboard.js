
function initCounterNumber() 
{
    var counter = document.querySelectorAll('.counter-value');
    var speed = 250; // The lower the slower

    counter.forEach(function (counter_value) {
    function updateCount() {
        var target = +counter_value.getAttribute('data-target');
        var count = +counter_value.innerText;
        var inc = target / speed;

        if (inc < 1) {
        inc = 1;
        } // Check if target is reached


        if (count < target) {
        // Add inc to count and output in counter_value
        counter_value.innerText = (count + inc).toFixed(0); // Call function every ms

        setTimeout(updateCount, 1);
        } else {
        counter_value.innerText = target;
        }
    }

    ;
    updateCount();
    });
}

