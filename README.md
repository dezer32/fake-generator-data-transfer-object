Генератор фейковых данных для dto - один раз напиши и больше не морочь голову ни себе, ни людям.

```bash
bin/console mock:dto:make Client
^ Dto\Client^ {#141
  +passport: Dto\Passport^ {#143
    +series: "8301"
    +number: "024729"
    +issue_date: DateTime @999300505 {#146
      date: 2001-08-31 23:28:25.0 UTC (+00:00)
    }
    #ignoreMissing: false
    #exceptKeys: []
    #onlyKeys: []
  }
  +phone: "+7 (984) 637-01-62"
  +email: "elvira46@drozdov.ru"
  +registration_address: "061181, Мурманская область, город Клин, пер. Бухарестская, 48"
  +birth_date: DateTime @252504479 {#145
    date: 1978-01-01 12:07:59.0 UTC (+00:00)
  }
  +last_name: "Фадеев"
  +middle_name: "Владимировна"
  +first_name: "Артемий"
  #ignoreMissing: false
  #exceptKeys: []
  #onlyKeys: []
}
```

Client - Имя dto относительно namespace ...\Dto\ и он описан аннотациями.

Генерирует фейковую dto согласно типа переменной/описанной аннотации.


Если нужно указать конкретные правила для конкретной переменной dto, например ФИО клиента (что бы это не было набором букв), то нужно над переменной указать аннотацию @FakeGenerator с параметром firstName:
```php
    /** @FakeGenerator lastName */
    public string $last_name;
    /** @FakeGenerator middleName */
    public string $middle_name;
    /** @FakeGenerator firstName */
    public string $first_name;
```

Или например дата выдачи паспорта не может быть ранее наступления 18 летнего возраста
```php
    /** @FakeGenerator dateTimeBetween ("-30 years", "-19 years") */
    public DateTimeInterface $issue_date;
```

Или номер телефона по dto это string, а по факту:
```php
    /** @FakeGenerator numerify ("+7 (9##) ###-##-##") */
    public string $phone;
```

Или по типу string по факту это какая-то строка для регулярки:
```php
    /** @FakeGenerator regexify ("[0-9]{4}") */
    public string $series;
    /** @FakeGenerator regexify ("[0-9]{6}") */
    public string $number;
```

Общий синтаксис использования аннотаций такой:
```php
    /** @FakeGenerator %Faker\Generator->methodName% ("%param1%", "%param2%") */
    /** @FakeCollection %Name\Space\To\Dto% */
```
Где:
1. %Faker\Generator->methodName% - имя метода с класса Faker\Generator
2. %param1%, %param2%, ..., %paramN% - параметры для этого метода
3. %Name\Space\To\Dto% - namespace класса вместе с классом, например: Dezer\FakeGeneratorDataTransferObject\ClassDto

PS: Разделение между параметрами `", "` обязательно и его нужно избегать в описании.