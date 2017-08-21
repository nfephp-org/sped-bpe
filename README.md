# sped-bpe

API para geração e comunicação das BPe com as SEFAZ autorizadoras

# APENAS DADOS INICIAIS NADA ÚTIL AINDA !!

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