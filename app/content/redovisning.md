Redovisning
====================================

Projekt
---------------------------------------

###Krav 1, 2, 3
För att ens komma åt hemsidan måste man vara inloggad. Det framgår att om man inte vill skapa ny användare går det bra att logga in med med den redan skapade användaren admin/admin. Tyckte det var en bra lösning istället för att låsa besökare ute från användandet av vissa funktioner och påtvinga inloggning i ett senare skede av ”användarflödet".

Väl på startsidan möts man av statisk information om hemsidan som snabbt gör det klart vad meningen med hemsidan är då jag tycker att det är viktigt att snabbt påvisa detta. På startsidan hittar man även 4 stycken små rutor som de mest använda taggarna, de nyaste inläggen, de mest aktiva användarna och slutligen de äldsta inläggen som ett försök att hålla gamla inlägg igång. Vad de 4 olika rutorna handlar om förstärks med hjälp av rubriker samt användandet av Font Awesome för att snabbt förklara vad varje ruta handlar om.  
Det finns en sida som kortfattad beskriver vilka som driver hemsidan och i vilket syfte. Information om hur man använder hemsidan samt information om utvecklaren återfinnes på denna sida.

Mycket av hemsidans funktioner göms i navigeringsmenyn som använder sig av dropdown. Detta för att jag inte ville ha en plottrig navbar som bara skulle distrahera. Alla länkar i navbaren har förstärkt innebörd med hjälp av Font Awesome.
En sida med alla taggar som används i diskussion finns där man även kan läsa en liten text om taggarnas funktion. Även här har jag förstärkt innebörden av det som visas med hjälp av Font Awesome.
I navbaren finns även en snabblänk till möjligheten att skapa ett nytt inlägg då jag kände att vana användare så snabbt som möjlig ska ha möjligheten att kunna publicera nya inlägg. 
Möjligheten att se alla inlägg finns också, där alla anknytande taggar återfinns samt möjligheten att klicka sig vidare till svaren på inläggen. Varje unikt inlägg separeras med samma skuggning som återfinns på startsidan för de 4 olika rutorna. Detta för att enkelt hålla i sär inläggen.

Alla användare finns listade på en separat sida och varje användare får en gravatar i form av ”retro” anknuten till sig. Klickar man på en användare ser man alla inlägg denne har gjort. Man kan även se sin egna profil och har möjligheten att uppdatera sin info.



###Hur projektet gick
Projektet har varit väldigt tidskrävande och jag kände mig väldigt stressand under projektets gång då det verkligen kändes som att jag hade tiden emot mig. Jag hade även lite svårt att se hur jag skulle få det tidigare erfarenheterna från det andra momenten att svetsas samman i projektet. Tycker att de tidigare kurserna förberedde en på ett bättre sätt inför projektet. Kanske beror det mer på min inlärningsmöjlighet då jag rent allmänt har haft lite svårt att ta in den här kursen, vad vet jag. 
Det var många gånger under projektets gång jag försökte blicka bakåt till de tidigare momenten för att försöka ta mig framåt. Ägnade även ca 2 dagar att repetera litteraturen, artiklarna och guiderna från de tidigare momenten innan jag började med projektet. Vet dock inte hur mycket det hjälpte då det var oerhört mycket att ta in och jag kände mig något stressad och tänkte att jag måste ju börja med själva projektet snart för att hinna med.

Till projektet använde jag mig av en sqlite-databas då verkade smidigast. Flytten från lokalt till drift blev enklare på så vis då exempelanvändare och inlägg ”följde med” när jag flyttade projektet till driftservern. Detta istället för att först fylla en lokal databas och sedan fylla en exakt kopia på på studentservern. Detta hade väl kunnat göras genom att exportera den lokala databasen i ren SQL-kod men jag ville hålla det så enkelt som möjligt. 

Kanske rent visuellt har överanvänt Font Awesome i projektet men det blir väl lätt så när det är något nytt och intressant. Men egentligen tycker jag att symboler många gånger kan förstärka innebörden av något, som exempelvis tag-ikonen bredvid alla taggar. Dock är det väl inte bra att låta användare gissa vad en ikon innebär alla gånger utan det är nog bra att i de flesta fall ha en text i anslutning.
Annars är min style inte något häpnadsväckande direkt. Använder små skuggor här och där för att lyfta fram olika ”block”. Länkar och 
annat smått och gott går i grönt. Den gröna färgen ska tydligen vara hexadecimalt korrekt färg för den gröna färg som är seriens signatur.

Tidsmässigt har jag förmodligen lagt ner mycket mer tid på detta projekt än de föregående och det har varit mycket mer stressande. Jag brukar föra anteckningar allt eftersom jag jobbar med kursmomenten och projekten och denna gång har noggrannheten i antecknandet blivit lidande av att jag kände mig stressad.
Då jag kände mig stressad och hade inte riktigt koll på läget blev min planering och struktur för utförandet av projektet inte den bästa heller.

###Tankar om kursen
Då jag läst denna kurs som den tredje inom kurspaketet kan jag bara svara ur ett perspektiv med de andra kurserna i ryggen.
Jag tycker att hoppet mellan denna kurs och den föregående var väldigt stort, även om det kanske är den naturliga gången av att gå från det ena till det andra. Om jag ser de tidigare kursernas moment som preparation inför de tidigare projekten tycker jag ändå att de tidigare projekten hade en bättre svårighetsgrad.

Kursmaterialet har i stort sätt varit okej. Det var väldigt många kapitel, artiklar samt länkar hit och dit som skulle gås igenom men strukturerade man upp det med en checklista för den initiala genomgången av momentens material gick det ändå att greppa omfattningen. Jag tycker däremot inte att guiderna var lika bra som de föregående kurserna. Jag fastnade många gånger i kursens olika guider med att jag inte tyckte det var självklart vart alla kod och alla filer hörde hemma. Visserligen kanske man kan se det som en naturlig följd av att kurserna blir mer och mer avancerade och att samma utförliga guider som exempelvis fanns i första kursen inte hör hemma i denna kurs. Men då jag tycker att kursen var ett sådant stort steg, svårighetsgrad-mässigt, hade jag ändå velat ha haft lite mer självklarheter i guiderna vart kod hör hemma. Jag hade även problem att arbeta med composer då det inte gick för mig att använda de kommando som användes i guiden rakt av i min terminal utan jag behövde utvidga kommandot något för att få det att fungera. Det var många sådana relativt små käppar i hjulet som tog onödigt lång tid att ta sig förbi och om jag tror hade kunnat undvikas av mer utförligare guider. Antingen då i ren text eller i videoform med ljud.
Annars har det varit intressant och lärorikt att ta nästa steget med Anax mot MVC och det kändes som ett steg i rätt riktning. Det var även intressant att få prova på LESS och responsive design.

Git och GitHub var ju något som tagits upp i tidigare i kurspaketet, då endast som extrauppgift. Då jag såg att det inte var en extrauppgift denna gång ( i alla fall för moment 5 och uppåt) valde jag att redan från första momentet att använda mig av versionshanteringen. Jag tyckte det var lite knepigt och svårt i början men såhär med lite mer erfarenhet av det är jag väldigt glad att just Git och GitHub togs upp i kursen då det verkligen är en sådan central och användbar del i utveckling, vare sig det är webbutveckling eller annan form av utveckling.         

Med tanke på vad jag skrivit ovan om kursen i allmänhet skulle jag ge den 6/10.

