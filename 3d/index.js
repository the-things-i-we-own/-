var Index = [
    "2022年8月13日(土) - 16日(火)　|　∧° ┐が BnA Alter Museum に滞在し、夏の自由研究を実施します。<br/>",
    "① 自分の所有するものを記録するホームページを作る　|　所要時間：約2時間半　|　参加費：2500円+税（事前予約制）<br/>",
    "② 所有するものを収納する箱を装飾する　|　参加費：1000円+税　|　※予約不要　|　",
    "③ 私（わたしたち）がBnA Alter Museumの周りで聞いた言葉　|　BnA Alter Museumに来る途中にあなたが聞いた言葉を（あなたが言葉を聞いた日時と場所をあわせて）持参してくださった方（先着10名）に、スティッキーアンドペン Think Note をプレゼント　|　持参した言葉は、BnA Alter Museum 1F受付にご提出ください。"
]

function more() {
    $("#header marquee").html(Index[Math.floor(Math.random() * Index.length)]);
}

var volume;
var synth;
var notes;
$(document).ready(function(event) {
    // StartAudioContext(Tone.context, window);  
    $(window).click(function() {
        Tone.context.resume();
    });

    volume = new Tone.Volume(-10);
    synth = new Tone.PolySynth(10, Tone.Synth).chain(volume, Tone.Master);
    notes = Tone.Frequency("C4").harmonize([1, 3, 5, 7, 9, 12]);
});

$("#marquee").click(function(e) {
    let randNote = Math.floor(Math.random() * notes.length);
    synth.triggerAttackRelease(notes[randNote], "2");
});

$("._more").click(function(e) {
    let randNote = Math.floor(Math.random() * notes.length);
    synth.triggerAttackRelease(notes[randNote], "1");
});

$("#greeting").click(function(e) {
    let randNote = Math.floor(Math.random() * notes.length);
    synth.triggerAttackRelease(notes[randNote], "1n");
});

$(".label").click(function(e) {
    let randNote = Math.floor(Math.random() * notes.length);
    synth.triggerAttackRelease(notes[randNote], "2n");
});

$(".list_item img").hover(function() {
    let randNote = Math.floor(Math.random() * notes.length);
    synth.triggerAttackRelease(notes[randNote], "4n");
});

$(".list_toggle").hover(function() {
    let randNote = Math.floor(Math.random() * notes.length);
    synth.triggerAttackRelease(notes[randNote], "8n");
});
