var Greeting = [
    "２０２２年７月２３日（土）〜　８月２１日（日）　｜　ビーエヌエーオルターミュージアムにて　｜　入場無料／会期中無休<br/>",
    "◎　ペフが所有する全てのもの（デジタル／フィジカル・新品／中古・制作物／販売品／非売品）を、発表／展示／販売する　",
    "｜　大切にしたいものを所有する・所有するものを大切にする<br/>",
    "｜　同時開催：令和四年版　夏の自由研究　｜　ビーエヌエーオルターミュージアムに宿泊する人たちの気持ちを知る・表す　｜　",
    "ビーエヌエーオルターミュージアムの周りで聞いた言葉を集めた地図を作る　｜　など"
]

function more() {
    $("#header marquee").html(Greeting[Math.floor(Math.random() * Greeting.length)]);
}

function greeting() {
    $("#greeting #text").html(Greeting);
}