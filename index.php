<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Distributor</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .container { max-width: 600px; margin: auto; }
        .person { border: 1px solid #ccc; padding: 10px; margin-top: 10px; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Card Distributor</h2>
        <p>Enter the number of people to distribute 52 playing cards randomly.</p>
        <input type="number" id="people" value="2" min="1">
        <button id="distribute">Distribute Cards</button>
        <p id="error-message" class="error"></p>
        <div id="result"></div>
    </div>

    <script>
        $(document).ready(function () {
            function formatCard(card) {
                /* Converts card values and suits into the required format */
                try {
                    let value = card.slice(0, -1);
                    let suit = card.slice(-1);
                    let suits = { 'S': 'S', 'H': 'H', 'D': 'D', 'C': 'C' };
                    let values = { '1': 'A', '10': 'X', '11': 'J', '12': 'Q', '13': 'K' };
                    return `${suits[suit]}-${values[value] || value}`;
                } catch (error) {
                    $('#error-message').text('Irregularity occurred');
                    throw new Error('Irregularity occurred');
                }
            }
            
            $('#distribute').click(function () {
                let people = parseInt($('#people').val());
                $('#error-message').text(''); // Clear previous errors
                $('#result').empty();
                
                if (!people || people < 1) {
                    $('#error-message').text('Input value does not exist or value is invalid');
                    return;
                }
                
                $.post('backend.php', { people: people }, function (data) {
                    try {
                        let output = '';
                        $.each(data, function (index, cards) {
                            let formattedCards = cards.map(formatCard).join(',');
                            output += formattedCards + '<br>';
                        });
                        $('#result').html(output);
                    } catch (error) {
                        $('#error-message').text('Irregularity occurred');
                    }
                }, 'json').fail(function () {
                    $('#error-message').text('Irregularity occurred');
                });
            });
        });
    </script>
</body>
</html>
