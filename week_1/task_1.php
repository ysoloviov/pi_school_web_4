<?php

$data = <<< TMAKR
Article:
    Header: BMW AG
    Body: Bayerische Motoren Werk is a German multinational company which currently produces automobiles and motorcycles, and also produced aircraft engines until 1945. The history of the name itself begins with Rapp Motorenwerke, an aircraft engine manufacturer. In April 1917, following the departure of the founder Karl Friedrich Rapp, the company was renamed Bayerische Motoren Werk
    ChangeMap:
        Bayerische Motoren Werk: Bavarian Motor Works(BMW)
    Tags: Automotive Industry, Germany, Luxury
Article:
    Header: Volkswagen
    Body:  Volkswagen is a German automaker founded on 28 May 1937 by the German Labour Front, and headquartered in Wolfsburg. Volkswagen was established in 1937 by the German Labour Front in Berlin.
    ChangeMap:
        Volkswagen: VW
        German: GR
    Tags: Automotive Industry, Germany, Not-Luxury
Article:
    Header: Project E
    Body: Project E was a joint project between the United States and the United Kingdom during the Cold War to provide nuclear weapons to the Royal Air Force (RAF) until sufficient British nuclear weapons became available. It was subsequently expanded to provide similar arrangements for the British Army of the Rhine
    ChangeMap:
        Project E: P.E.
    Tags: Military Industry, USA
Article:
    Header: Ford Motor Company
    Body: Ford Motor Company is a multinational automaker that has its main headquarter in Dearborn, Michigan, a suburb of Detroit. It was founded by Henry Ford and incorporated on June 16, 1903.
    ChangeMap:
        Ford Motor Company: Ford
    Tags: Automotive Industry, USA, Not-Luxury
Article:
    Header: Studebaker US6
    Body: The Studebaker US6 (G630) was a series of 2½-ton 6x6 and 5-ton 6x4 trucks manufactured by the Studebaker Corporation and REO Motor Car Company during World War II. The basic cargo version was designed to transport a 5,000 lb (2,300 kg) cargo load over all types of terrain in all kinds of weather.
    Tags: Heavy Automotive Industry, USA, Not-Luxury
TMAKR;

/*
    ЗАДАНИЕ:
    
    Нужно разобраться $data с описанием статьей и выввести статьи у которых есть тег Automotive Industry в виде html документа следующего формата:
    
        - весь документ оборачиваеться в стандартные html, body теги
        - body состоит из 3х тегов table-of-content, content, tags
        - table-of-content тег включвает в себя "Header"ы всех параграфов обернутые в div тег
        - content состоит и article тегов
        - каждый article включает в себя h1 тег с "Header" параграфа и p тег с "Body" парагрофа,
        - перед выводом каждого "Body" в нем должна быть проведина замена из "ChangeMap" справа на лево, к примеру Volkswagen: VW, значит все слова Volkswagen нужно заменить на VW
        - тег tags должен состоять из уникальных тегов из всех секций Tags разделенные ", ", даже если тег встречаеться больше одного раза то все равно в tags должен быть только раз
        
    ПОЖЕЛАНИЯ:
        - всему даем адекватные имена, классам, методам, переменныем. Чтоб было понятно что они делают, односимвольные переменные могут быть только для счетчика
        - используем классы, весь код которые делает чтото больше раза заворачиваем в методы, и даем понятное имя
        - отделяем логику от представления и используем массимы. То есть лучше сначало разобрать все данные и разместить их в массив/массивы и потом
          в цикле выводить на экран чем зем за один проход сделать все
        - не забываем про коментарии
        - функции лучше делать мальенькие, до 20 строк, это не обязательное правило, но к этому нужно стермиться, в последствии вы поймете
          почему 20 и почему иногда нужно сделать больше
    
   
    ПРИМЕР: если бы $data состоял только из первого парагрофа то html документ выглядел бы так:


<html>
    <body>
        <table-of-content>
            <div>BMW AG</div>
        </table-of-content>
        <content>
            <article>
                <h1>BMW AG</h1>
                <p>Bavarian Motor Works(BMW) is a German multinational company which currently produces automobiles and motorcycles, and also produced aircraft engines until 1945. The history of the name itself begins with Rapp Motorenwerke, an aircraft engine manufacturer. In April 1917, following the departure of the founder Karl Friedrich Rapp, the company was renamed Bavarian Motor Works(BMW)</p>
            </article>
        </content>
        <tags>Automotive industry, Germany, Luxury</tags>
    </body>
</html>


*/
