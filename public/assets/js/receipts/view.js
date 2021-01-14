let morris_data = {'element': 'distr-bar-chart'};

$.getJSON('/receipts/api/morris_data/'+receipt_id)
.done(function (json) {
    morris_data = Object.assign(morris_data, json);
})
.fail(function (jqxhr, textStatus, error) {
    morris_data = Object.assign(morris_data, {'error': jqxhr.status});
});

let morris_init_interval;
$(function() {
    morris_init_interval = setInterval(function () {
        if ($.isEmptyObject(morris_data) === false) {
            clearInterval(morris_init_interval);
            if ('error' in morris_data) {
                console.log(morris_data);
            } else {
                Morris.Bar(morris_data);
            }
        }
    }, 250);
});
