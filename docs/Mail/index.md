# Mail MailIncoming MailOutcoming

### Request

`POST https://localhost/api/mails`

```json
{

}
```

### Response

```json
{
    "@context": "/api/contexts/Mail",
    "@id": "/api/mails/1",
    "@type": "Mail"
}
```

### Request

`POST https://localhost/api/mail_incomings`

```json
{
    "subject": "this is subject",
    "recipients" : [
        "api/users/1"
    ]
}
```

### Response

```json
{
    "@context": "/api/contexts/MailIncoming",
    "@id": "/api/mail_incomings/2",
    "@type": "MailIncoming",
    "recipients": [
        "/api/users/1"
    ],
    "subject": "this is subject"
}
```

### Request

`POST https://localhost/api/mail_outcomings`

```json
{
    "subject": "this is subject",
    "recipient": "this is recipient from outcoming"
}
```

### Response

```json
{
    "@context": "/api/contexts/MailOutcoming",
    "@id": "/api/mail_outcomings/3",
    "@type": "MailOutcoming",
    "recipient": "this is recipient from outcoming"
}
```

### Request

`GET https://localhost/api/mails`

### Response

```json
{
    "@context": "/api/contexts/Mail",
    "@id": "/api/mails",
    "@type": "hydra:Collection",
    "hydra:member": [
        {
            "@id": "/api/mails/1",
            "@type": "Mail"
        },
        {
            "@id": "/api/mail_incomings/2",
            "@type": "MailIncoming",
            "recipients": [
                "/api/users/1"
            ],
            "subject": "this is subject"
        },
        {
            "@id": "/api/mail_outcomings/3",
            "@type": "MailOutcoming",
            "recipient": "this is recipient from outcoming"
        }
    ],
    "hydra:totalItems": 14
}
```
