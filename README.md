# Mangosteen

Mangosteen is web dashboard for running application under new subdomain.

## Installation

1. Configure wildcard subdomain.

2. Copy and run installation shell script from this repository [mangosteen.sh](https://github.com/Cherry-Pie/Mangosteen/blob/master/mangosteen.sh) or curl it:

```bash
bash <(curl -sl https://raw.githubusercontent.com/Cherry-Pie/Mangosteen/master/mangosteen.sh)
```

3. Follow instructions to set necessary variables and create `docker-compose.yml`.
4. Add your services to `docker-compose.yml` if needed.
5. Run `docker-compose up -d`

## Usage

Open dashboard at subdomain that was specified via installation processs and start clicking buttons.

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)