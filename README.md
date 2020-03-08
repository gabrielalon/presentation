1. Domain-Driven Design (DDD) - to podejście, które pomaga w zrozumieniu i budowie projektów oprogramowania. Nie jest zatem wzorcem projektowym. Jest podejściem do rozwoju wiedzy na temat biznesu i wykorzystania technologii w celu dostarczenia gotowego produktu. Zatem nie ma znaczenia wykorzystana technologia, kod jest jedynie źródłem do celu. Docelowe oprogramowanie jest tylko środkiem do rozwiązywania problemów biznesowych. Projektowanie oparte na domenie kładzie nacisk na upewnienie się, że firmy i programiści mówią w tym samym języku. Tworzy się tak zwany język wszechobecny zrozumiały dla wszystkich stron. Ze swojej praktyki mogę dodać, że współpraca z klientem jest w tej sytuacji efektowniejsza z tego względu, że kod w dużej mierze odzwierciedla logikę biznesową. Nie oznacza to oczywiście, że należy wykorzystywać DDD w każdym projekcie. W sytuacji gdy nasz projekt w dużym stopniu odzwierciedla jedynie odczyt, zapis, i usuwanie pojedyńczego rekordu w bazie. Czyli gdy mamy do czynienia z CRUDem wówczas niniejsze podejście nie będzie pomocne. W sytuacji gdy nasze encje, mają dużą zależność: zmiana jednej pociąga za sobą łańcuch innych zmian, wówczas strategia DDD wydaje się być warta do rozważenia. Nie ulega wątpliwości, że jest to podejście długoterminowe, które pomaga zarządzać rozwojem skomplikowanego oprogramowania. W której obie strony muszą aktywnie uczestniczyć i stale ze sąbą współracować.
Tyle może tytułem wstępu, ponieważ celem niniejszego spotkania jest omówienie wzorca CQRS + ES, które stanowią z kolei jeden z technicznych wzorców do rozwoju oprogramowania w metodologii DDD.
Dla zainteresowanych tematem w szczegółach na koniec przedstawię bibliografię do tematu.

2. Na potrzeby niniejszej prezentacji/spotkania przygotowałem prosty program. Niniejszą funkcjonalność napisałem 3 razy. Tzn. w metodologii, którą zdaje się najczęściej można spotkać, następnie w metodologii CQRS oraz CQRS + ES.

Nasz program to system do zarządzania magazynem w sklepie internetowym. Dość dokładnie prezycuję, że chodzi o magazyn sklepu internetowego, ponieważ w rzeczywistości dzisiejsze duże sklepy internetowe nie realizują zamówień z jednego magazynu a z kilku.
W naszym internetowym magazynie mamy do czynienia jedynie z 3 operacjami: 
- dodawania x sztuk towaru na magazyn
- odejmowania x sztuk towary z magazynu
- dokonanie korekty ilości towaru w magazynie
Ktoś przytomnie może powiedzieć to podjabła cały DDD tylko do 3 operacji! To prawda, niemniej zwracam uwagę, że na potrzeby prezentacji jedynie pokazuje wycinek funkcjonalności dużego sklepu internetowego oraz ponadto na tym prostym przykładzie chciałem zaprezentować różnicę wynikającą z różnych podejść projektowania architektury i co one dają.

Przechodząc do rzeczy: cały system magazynowy napisałem w laravelu. Z informacji przekazanych przez Artura wiem że dla wszystkich jest on znany, niemniej zaznaczam, że framework nie ma znaczenia w niniejszym przykładzie. Tak samo jak nie ma znaczenia w całej metodologii DDD.
Nasz system magazynowy to tzw bounded cotext. Nasz sklep internetowy ma mase funkcjonalności i nie sposób byłoby utworzyć jeden słownik dla języka wszechobecnego. Dlatego w sytuacji dużych i złożonych projektów dzieli się je na mniejsze contexty. I wówczas operuje się językiem w odniesieniu do jednego zakresu, kontekstu. Zatem nasz context to system magazynowy a nasz język wszechobecny to:
- magazyn (może byc ich wiele, na potrzeby przykładu zahardkodowałem listę dostępnych magazynów, wynika to z tego, że w trakcie składania zamówienia musi ono być podzielone względem magazynów, które moga je zrealizować a następnie zostać one "wysłane" najczęściej za pomocą jakieś integracji SOAP lub REST, możliwość ręcznego ich tworzenia i tak nie ma sensu, ponieważ były by one puste)
- towar, czyli pozycja na poszczególnym magazynie. W świecie magazynowym jest bardzo łatwo zdefiniować towar. Musi on mieć tzw symbol SKU, lub EAN. Każde z nich można precyzyjnie zwalidować, zatem nie jest to do końca byle jaki ciąg znaków i liczb.
- stan magazynowy: czyli ilość dostępnych sztuk towaru na magazynie
- wydanie towary z magazynu: czyli odjęcie x szt towaru 
- przyjęcie towaru na magazyn: czyli dodanie x szt
- korekta towaru w magazynie: czyli czasem dojdzie do zniszczenia, kradzieży, sprzedaży poza sklepem internetowym.. itd itd

W pierwszym podejściu napisałem niniejszą funckjonalność.. nazwijmy to standardowo. Tzn: operujemy wg wzorca MVC, czyli:
1. przychodzi request
2. trafia on do akcji w kontrolerze
3. dokonujemy walidacji danych
4. wywołujemy serwis (zakładam optymistyczny scenariusz, że kod nie miści się w kontrolerze)
5. wypluwam odpowiedź do widoku

Mój serwis składa się z 3 metod: zmijszenie stanu, zwiększenie i uzupełnienie towaru. Wnętrze tego towaru wywołuje jedną z 2 poprzednich metod w zależności gdy różnica między nową wartością a starą jest dodatnia lub ujemna. Zera pomijam.

Teraz chciałbym abyśmy przyjrzeli się rozwiązaniu drugiemu tzn CQRS. W pierwszej kolejności muszę znów odrobinę zatrzymać się i dodać kilka słów.
http://q.i-systems.pl/file/e7afc254.png Otóż zwróćmy uwagę, że niniejsza aplikację możemy podzielić na następujące warstwy.

Czyli mamy:
1. warstę odpowiedzialna za interfejs użytkownika, która przyjmuje request
2. warstwę do enkapsulacji dostępu do danych i manipulacji
3. wartwę do obsługi infrastruktury: czyli zapis do różnych baz danych

W kolejnym przykładzie widać niniejszy rozdział dość precyzyjnie pod postacią 4 folderów.

Kolejnym krokiem było zaaplikowanie Command Query Responsibility Segregation (CQRS).
http://q.i-systems.pl/file/0756ba9e.png

Niniejszy wzorzec dąży do jeszcze bardziej agresywnego rozdzielenia wspomnianych warstw, dzieląc Model na dwie części:
Model zapisu: znany również jako model poleceń, wykonuje zapisy i bierze odpowiedzialność za prawdziwe zachowanie Domeny.
Model odczytu: bierze odpowiedzialność za odczyty w aplikacji i traktuje je jako coś, co powinno być poza modelem domeny.

W tym celu utworzyłem sobie tzw. message bus. Istnieje wiele gotowych rowzwiązań dostępnych do różnych farmeworków, które zawierają wiele dodatkowych funkcjonalności. Ja na potrzeby prezentacji napisałem swój najprostszy aby lepiej było widać co się dzieje.

Mamy tutaj rodział na query i command
Kontroler nadal ma serwis
Serwis wykorzystuje message busa i w zależności od akcji dokonuje jedną z trzech operacji
W domenie znalazły się modele oraz encje. Zwracam uwagę, że one nie musza byc tożsame. Tak samo Read modele nie sa tożsame z modelami do zapisu.
Złożoność read modelu zależy od potrzeb danych jakie musimy przekazać do widoku a nie od potrzeb zapisu.
W sytuacji gdyby należało zmienić logikę zapisu ne musimy nic zmieniac w odczycie. Ponieważ realizują je niezależne serwisy. Ewentualna refaktoryzacja wydaje sie być tutaj prostsza


CQRS + ES
http://q.i-systems.pl/file/c7d251c3.png
Tutaj jak widać odrobinę rozbudowujemy nasz wcorzec CQRS o element Event sourcing.
O teraz dokonywanie operacji na modelu to w rzeczywistości zmiana jego stanu.
W chwili zapisu takiego modelu musimy dokonać tzw  projekcji wszystkich zmian stanu do: bazy, read modelów i innych operacji: byc może jakies notyfikacje., itp.

W tym miejscu pojawiają się kolejne nowe pozycje:
Agregaty, które stanowią kolekcję/zbiór zmian jakie zaszły w modelu oraz zawierają kolekcję/zbiór VO
Value Object, jest to najprostszy obiekt w systemi. Jest obiektowa reprezentacja najprostszych typów danych: stringa, daty, pieniądza. Ich różnorodność nie opiera się na tożsamości, ale na posiadanej treści.

I tak np, nasz stan jest reprezentowany przez ilość, EAN oraz nazwę magazynu. Każdą z tych wartości zamknąłem w VO, który dodatkowo waliduje przekazane parametry.
Ponadto WarehouseState zyskał kolejne pole tj Uuid, ponieważ dla możliwości śledzenia poszczególnych zmian w encji jest to najłatwiejszy sposób odniesienia się do centralnege modelu. Inaczej aggregate roota. Celem Universally unique identifier jest umożliwienie systemom rozproszonym jednoznacznej identyfikacji informacji bez znaczącej koordynacji centralnej.



Bibliografia:
1. Domain Driven Design Distilled by Vaughn Vernon
2. Domain-Driven Design Reference: Definitions and Pattern Summaries by Eric Evans
3. Domain-Driven Desing in PHP
4. https://cqrs.nu/
5. https://zawarstwaabstrakcji.pl/

Biblioteki
http://getprooph.org/
https://symfony.com/doc/current/components/messenger.html
http://labs.qandidate.com/blog/2014/08/26/broadway-our-cqrs-es-framework-open-sourced/