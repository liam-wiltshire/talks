<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>


<div class="container">
    <div class="card text-white bg-primary mb-4 mt-4">
        <div class="card-header">
            <h3>Predicted Language: <span id="prediction"></span></h3>
        </div>
        <div class="card-body">
            <div id="quote" class='mb-3 mt-3'></div>
        </div>
        <div class="card-footer">
            <p class='mb-0'>'e' - English, 'f' - French, 'd' - German</p>
        </div>


    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script type="text/javascript">

        var categories = {
            "e": "English",
            "f": "French",
            "d": "German"
        };

        function getQuote(){

            var index = Math.round(Math.random()*quotes.length);
            quote = quotes[index];
            jQuery("#quote").text(quote);

            $.ajax({
                method: "GET",
                data: {data: quote},
                url: "/classify",
                success: function(data) {
                    console.log(data);
                    if (data.probability >= 0.1) {
                        jQuery("#prediction").text(data.category);
                    } else {
                        jQuery("#prediction").text("???");
                    }
                }
            });


        };


        jQuery(document).keypress(function(ev) {
            if (categories[ev.key]){
                $.ajax({
                    method: "POST",
                    header: "Content: text/json",
                    data: {data: jQuery("#quote").text(), category: categories[ev.key]},
                    url: "/train",
                    complete: getQuote
                });
            } else {
                getQuote();
            }
        });

        var quotes = [
            "A man who is his own lawyer has a fool for a client",
            "A fool and their money are soon parted.",
            "There's no fool like an old fool.",
            "Don't throw good money after bad.",
            "Throw your hat into the ring.",

            "Behind every great man there's a great woman.",
            "Early to bed and early to rise makes one healthy, wealthy and wise.",
            "The early bird catches the worm.",
            "Your time is limited, so don't waste it living someone else's life.",
            "Give a man a fish and you will feed them for a day.",

            "Procrastination is the thief of time.",
            "A stitch in time saves nine.",
            "The bane of my life.",
            "A legend in one's own lifetime",
            "In one fell swoop",

            "On ne change pas une équipe qui gagne",
            "Il n'y a pas de fumée sans feu",
            "Il n'y a pas de verités moyennes",
            "On n'apprend pas aux vieux singes à faire des grimaces",
            "Il vaut mieux faire que dire",

            "Vaut mieux prévenir que guérir",
            "Dis-moi ce que tu manges, je te dirai ce que tu es",
            "La mort n'a peut-être pas plus de secrets à nous révéler que la vie",
            "Il n'y a qu' un bonheur dans la vie, c'est d'aimer et d'être aimé",
            "Avoir un chat dans la gorge",

            "Avoir un poil dans la main",
            "Avoir deux mains gauches",
            "Un tien vaut mieux que deux tu l'auras",
            "Avoir d'autres chats à fouetter",
            "Pas avoir de quoi fouetter un chat",


            "Das Leben ist kein Ponyhof",
            "Arbeit ist die beste Jacke",
            "Niemand kann mir das Wasser reichen",
            "Das macht mir so schnell keiner nach",
            "Wo sich die Füchse gute Nacht sagen",

            "Das Billige ist immer das Teuerste",
            "Das ist mir Wurst.",
            "Tut mir leid, aber mein Englisch ist under aller Sau.",
            "Aller Anfang ist schwer",
            "Nun schlägt’s aber dreizehn",

            "Kleinvieh macht auch Mist",
            "Übung macht den Meister",
            "Wenn man dem Teufel den kleinen Finger gibt, so nimmt er die ganze Hand",
            "Kinder und Betrunkene sagen immer die Wahrheit",
            "Das Billige ist immer das Teuerste.",


        ];

        getQuote();

    </script>

</body>
</html>
