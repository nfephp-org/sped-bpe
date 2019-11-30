# sped-bpe

API para geração e comunicação das BPe com as SEFAZ autorizadoras

[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

[![Latest Stable Version][ico-stable]][link-packagist]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![License][ico-license]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]

[![Issues][ico-issues]][link-issues]
[![Forks][ico-forks]][link-forks]
[![Stars][ico-stars]][link-stars]

## Estados atendidos

- Todos exceto SC (Santa Catarina)

# Projeto em BETHA test

## Considerações Iniciais
O Bilhete de Passagem Eletrônico (BP-e) está sendo desenvolvido de forma integrada pelas
Secretarias de Fazenda das Unidades Federadas, Receita Federal do Brasil – RFB,
representantes das empresas de transporte de passageiros e Agências Reguladoras do
segmento de transporte, a partir da assinatura do Protocolo ENAT, que atribuiu ao Encontro
Nacional de Coordenadores e Administradores Tributários Estaduais (ENCAT) a coordenação e
a responsabilidade pelo desenvolvimento e implantação do Projeto BP-e.

### Conceito do BP-e
Bilhete de Passagem Eletrônico (BP-e) é o documento emitido e armazenado eletronicamente,
de existência apenas digital, cuja validade jurídica é garantida pela assinatura digital do
emitente e autorização de uso pela administração tributária da unidade federada do
contribuinte, antes da ocorrência do fato gerador.
O Bilhete de Passagem Eletrônico (Modelo 63) poderá ser utilizado, a critério das unidades
federadas para substituir um dos seguintes documentos fiscais:

- Bilhete de Passagem Rodoviário, modelo 13;
- Bilhete de Passagem Aquaviário, modelo 14;
- Bilhete de Passagem Ferroviário, modelo 16;
- Cupom Fiscal Bilhete de Passagem emitido por equipamento Emissor de Cupom Fiscal (ECF)

### Descrição Simplificada do Modelo Operacional
A empresa emissora do BP-e gerará um arquivo eletrônico contendo as informações fiscais da
prestação do serviço de transporte de passageiros, o qual deverá ser assinado digitalmente, de
maneira a garantir a integridade dos dados e a autoria do emissor, com certificado ICP-Brasil.
O arquivo eletrônico do BP-e, será transmitido pela Internet, para o ambiente autorizador, que
fará uma validação do arquivo e devolverá uma mensagem eletrônica com o resultado da
validação, podendo ser: rejeição ou autorização de uso. Sendo que só poderá iniciar a
prestação do serviço de transporte de passageiros, quando tiver a sua autorização de uso.
Para acompanhar o passageiro deverá ser impresso, em papel, um documento auxiliar do BP-e
– DABPE, de acordo com leiaute definido capítulo 8 deste manual.
O sistema BP-e implementa o conceito de “evento”, que é o registro de uma ação ou situação
relacionada com o documento, que ocorreu após a autorização de uso, como o registro de um
cancelamento, por exemplo

## Requirements

Para que este pacote possa funcionar são necessários os seguintes requisitos do PHP e outros pacotes dos quais esse depende.

- PHP 7.x (recomendável PHP 7.2) 
- ext-curl
- ext-dom
- ext-json
- ext-gd
- ext-mbstring
- ext-mcrypt
- ext-openssl
- ext-soap
- ext-xml
- ext-zip
- [sped-common](https://github.com/nfephp-org/sped-common)

## Documentation

O processo de documentação ainda não foi inciado.

## Contributing

Para contribuir com correções de BUGS, melhoria no código, documentação, elaboração de testes ou qualquer outro auxílio técnico e de programação por favor observe o [CONTRIBUTING](CONTRIBUTING.md) e o  [Código de Conduta](CONDUCT.md) para maiores detalhes.

## Change log

Acompanhe o [CHANGELOG](CHANGELOG.md) para maiores informações sobre as alterações recentes.

## Testing

Todos os testes são desenvolvidos para operar com o PHPUNIT

## Security

Caso você encontre algum problema relativo a segurança, por favor envie um email diretamente aos mantenedores do pacote ao invés de abrir um ISSUE.

## Credits

Roberto L. Machado (owner and developer)

## License

Este pacote está diponibilizado sob LGPLv3 ou MIT License (MIT). Leia  [Arquivo de Licença](LICENSE.md) para maiores informações.

[ico-stable]: https://poser.pugx.org/nfephp-org/sped-bpe/version
[ico-stars]: https://img.shields.io/github/stars/nfephp-org/sped-bpe.svg?style=flat-square
[ico-forks]: https://img.shields.io/github/forks/nfephp-org/sped-bpe.svg?style=flat-square
[ico-issues]: https://img.shields.io/github/issues/nfephp-org/sped-bpe.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/nfephp-org/sped-bpe/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/nfephp-org/sped-bpe.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nfephp-org/sped-bpe.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/nfephp-org/sped-bpe.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/nfephp-org/sped-bpe.svg?style=flat-square
[ico-license]: https://poser.pugx.org/nfephp-org/nfephp/license.svg?style=flat-square
[ico-gitter]: https://img.shields.io/badge/GITTER-4%20users%20online-green.svg?style=flat-square


[link-packagist]: https://packagist.org/packages/nfephp-org/sped-bpe
[link-travis]: https://travis-ci.org/nfephp-org/sped-bpe
[link-scrutinizer]: https://scrutinizer-ci.com/g/nfephp-org/sped-bpe/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nfephp-org/sped-bpe
[link-downloads]: https://packagist.org/packages/nfephp-org/sped-bpe
[link-author]: https://github.com/nfephp-org
[link-issues]: https://github.com/nfephp-org/sped-bpe/issues
[link-forks]: https://github.com/nfephp-org/sped-bpe/network
[link-stars]: https://github.com/nfephp-org/sped-bpe/stargazers
[link-gitter]: https://gitter.im/nfephp-org/sped-bpe?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge