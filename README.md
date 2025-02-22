# Практическая работа PHP

**`example_persons_array.php`** - массив, как аргумент для некоторых функций, описанных в этой работе.

## Разбиение и объединение ФИО

`getPartsFromFullname` принимает как аргумент одну строку — склеенное ФИО. Возвращает как результат массив из трёх элементов с ключами `'surname', 'name', 'patronomyc'`.  
Пример: как аргумент принимается строка `'Иванов Иван Иванович'`, а возвращается массив `['surname' => 'Иванов', 'name' => 'Иван', 'patronomyc' => 'Иванович']`.

`getFullnameFromParts` принимает как аргумент три строки — фамилию, имя и отчество. 
Возвращает как результат их же, но склеенные через пробел.  
Пример: как аргументы принимаются три строки `'Иванов'`, `'Иван'` и `'Иванович'`, а возвращается одна строка — `'Иванов Иван Иванович'`.


## Сокращение ФИО

Функция `getShortName`, принимает как аргумент строку, содержащую ФИО вида "Иванов Иван Иванович" и возвращающую строку вида `Иван И.`, где сокращается фамилия и отбрасывается отчество.

Для разбиения строки на составляющие используется функция `getPartsFromFullname`.

## Функция определения пола по ФИО

Функция `getGenderFromName`, принимает как аргумент строку, содержащую ФИО (вида "Иванов Иван Иванович").
Определение производится следующим образом:
* внутри функции делим ФИО на составляющие с помощью функции `getPartsFromFullname`;
изначально "суммарный признак пола" считаем равным 0;
* если присутствует признак мужского пола — прибавляем единицу, если женского — отнимаем единицу.
* после проверок всех признаков, если "суммарный признак пола":
  * больше нуля — возвращаем 1 (мужской пол);
  * меньше нуля — возвращаем -1 (женский пол);
  * равен 0 — возвращаем 0 (неопределенный пол).

Признаки мужского пола:
* отчество заканчивается на "ич";
* имя заканчивается на "й" или "н";
* фамилия заканчивается на «в».

Признаки женского пола:
* отчество заканчивается на "вна";
* имя заканчивается на "а";
* фамилия заканчивается на "ва";

## Определение возрастно-полового состава

Функция getGenderDescription принимает как аргумент массив `$example_persons_array`.
Как результат функции возвращается информация в следующем виде:

Гендерный состав аудитории:  
\---------------------------  
Мужчины - 55.5%  
Женщины - 35.5%  
Не удалось определить - 10.0%

Используется функция фильтрации элементов массива, функция подсчета элементов массива, функция `getGenderFromName`, округление.

## Идеальный подбор пары

Функция `getPerfectPartner` принимает:
* первые три аргумента - строки с фамилией, именем и отчеством (регистр может быть любым); добавлена проверка аргументов на неопределенный пол;
* четвертый аргумент - массив `$example_persons_array`.

Алгоритм поиска идеальной пары:
1. фамилию, имя, отчество приводятся к нужному регистру;
2. функция `getFullnameFromParts` объединяет ФИО;
3. функция `getGenderFromName` определяет пол для ФИО;
4. ФИО проверяется на неопределенный пол, если пол неопределен выводится соответствующее сообщение, если пол определенный, работа функции продолжается;
5. случайным образом выбирается любой человек в массиве;
6. `getGenderFromName`, проверяет, что выбранное из массива ФИО - противоположного пола, если нет, то возвращаемся к шагу 4, если да - возвращаем информацию.

Как результат функции возвращается информация в следующем виде:  
Иван И. + Наталья С. =   
♡ Идеально на 64.43% ♡

Процент совместимости "Идеально на ..." — случайное число от 50% до 100% с точностью два знака после запятой.
