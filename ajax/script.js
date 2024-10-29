$(document).ready(function () {
    $("#event").on("change", function (event) {
        let eventid = event.target.value;
        window.events.forEach(function(event){
            if (event.id == eventid) {

                console.log(event)

                let message = '';
                if (event?.ticket_adult_price) {
                    message += '<p>Цена взрослого билета ' + event.ticket_adult_price + '. Выберете количество: <input name="ticket_adult" type="number" id="ticket_adult" value="0" min="0" required></p>';
                }
                if (event?.ticket_kid_price) {
                    message += '<p>Цена детского билета ' + event.ticket_kid_price + '. Выберете количество: <input name="ticket_kid" type="number" id="ticket_kid" value="0" min="0" required></p>';
                }
                if (event?.ticket_preferential_price) {
                    message += '<p>Цена льготного билета ' + event.ticket_preferential_price + '. Выберете количество: <input name="ticket_preferential" type="number" id="ticket_preferential" value="0" min="0" required></p>';
                }
                if (event?.ticket_group_price) {
                    message += '<p>Цена группового билета ' + event.ticket_group_price + '. Выберете количество: <input name="ticket_group" type="number" id="ticket_group" value="0" min="0" required></p>';
                }
                $("#results").empty().append(message);
            }
        })
    });

    $("#add_form").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            url: "/ajax/save_order.php",
            method: "post",
            data: $("form").serialize(),

        }).done(function (data) {
            // Успешное получение ответа
            console.log(data);
            event.target.reset();
        });
    });
});