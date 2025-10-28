# Hedera SDK PHP

[![Tests](https://github.com/zircon-tech/hedera-sdk-php/actions/workflows/test.yml/badge.svg)](https://github.com/zircon-tech/hedera-sdk-php/actions/workflows/test.yml)

# Rationale

# Process

1. Install or build protocol buffers compiler (`protoc`) with php plugins.
Instructions from https://grpc.io/docs/languages/php/quickstart/
```shell
git clone --recurse-submodules -b v1.75.1 --depth 1 --shallow-submodules https://github.com/grpc/grpc
bazel build @com_google_protobuf//:protoc //src/compiler:all v1.75.1
# bazel does not work with 1.40
#git clone --recurse-submodules -b v1.40.0 --depth 1 --shallow-submodules https://github.com/grpc/grpc
#bazel build @com_google_protobuf//:protoc //src/compiler:all v1.40.0
```
2. Clone protocol buffers specs from official hedera repo.
```shell
git clone https://github.com/hashgraph/hedera-protobufs/releases/tag/v0.62.4
```
3. Generate php stubs for desired protocol buffers packages.
```shell
protoc --descriptor_set_out=out.protoset --include_imports --proto_path=./services --proto_path=./platform services/*.proto
../grpc/bazel-bin/external/com_google_protobuf/protoc --descriptor_set_out=out.protoset --include_imports --proto_path=../grpc/third_party/protobuf/src/ --proto_path=./services --proto_path=./mirror --proto_path=./platform --php_out=../hedera-php/Generatedmirror2 --grpc_out=../hedera-php/Generatedmirror2 --plugin=protoc-gen-grpc=../grpc/bazel-bin/src/compiler/grpc_php_plugin_binary mirror/*.proto
../grpc/bazel-bin/external/com_google_protobuf/protoc --descriptor_set_out=out.protoset --include_imports --proto_path=../grpc/third_party/protobuf/src/ --proto_path=./services --proto_path=./platform --proto_path=./platform/event --proto_path=./platform/state --php_out=../hedera-php/Generated --grpc_out=../hedera-php/Generated --plugin=protoc-gen-grpc=../grpc/bazel-bin/src/compiler/grpc_php_plugin_binary services/*.proto
../grpc/bazel-bin/external/com_google_protobuf/protoc --descriptor_set_out=out.protoset --include_imports --proto_path=../grpc/third_party/protobuf/src/ --proto_path=./services --proto_path=./platform --proto_path=./platform/event --proto_path=./platform/state --php_out=../hedera-php/Generatedplatformevent --grpc_out=../hedera-php/Generatedplatformevent --plugin=protoc-gen-grpc=../grpc/bazel-bin/src/compiler/grpc_php_plugin_binary platform/event/*.proto
../grpc/bazel-bin/external/com_google_protobuf/protoc --descriptor_set_out=out.protoset --include_imports --proto_path=../grpc/third_party/protobuf/src/ --proto_path=./services --proto_path=./platform --proto_path=./platform/event --proto_path=./platform/state --php_out=../hedera-php/Generatedauxiliaryhints --grpc_out=../hedera-php/Generatedauxiliaryhints --plugin=protoc-gen-grpc=../grpc/bazel-bin/src/compiler/grpc_php_plugin_binary services/auxiliary/hints/*.proto
../grpc/bazel-bin/external/com_google_protobuf/protoc --descriptor_set_out=out.protoset --include_imports --proto_path=../grpc/third_party/protobuf/src/ --proto_path=./services --proto_path=./platform --proto_path=./platform/event --proto_path=./platform/state --php_out=../hedera-php/Generatedstatehints --grpc_out=../hedera-php/Generatedstatehints --plugin=protoc-gen-grpc=../grpc/bazel-bin/src/compiler/grpc_php_plugin_binary services/state/hints/*.proto
../grpc/bazel-bin/external/com_google_protobuf/protoc --descriptor_set_out=out.protoset --include_imports --proto_path=../grpc/third_party/protobuf/src/ --proto_path=./services --proto_path=./platform --proto_path=./platform/event --proto_path=./platform/state --php_out=../hedera-php/Generatedauxiliaryhistory --grpc_out=../hedera-php/Generatedauxiliaryhistory --plugin=protoc-gen-grpc=../grpc/bazel-bin/src/compiler/grpc_php_plugin_binary services/auxiliary/history/*.proto
../grpc/bazel-bin/external/com_google_protobuf/protoc --descriptor_set_out=out.protoset --include_imports --proto_path=../grpc/third_party/protobuf/src/ --proto_path=./services --proto_path=./platform --proto_path=./platform/state --php_out=../hedera-php/Generatedstatehistory --grpc_out=../hedera-php/Generatedstatehistory --plugin=protoc-gen-grpc=../grpc/bazel-bin/src/compiler/grpc_php_plugin_binary services/state/history/*.proto
```
4. Build higher-level wrappers around the raw clients.

5. Build required grpc extensions.
```shell
# PECL setup for debian-based systems 
apt install php-dev php-pear composer
pecl install grpc-1.76.0
# Config for php v 8.1
echo -e "; configuration for php grpc module\n; priority=20\nextension=grpc.so\n" > /etc/php/8.1/mods-available/grpc.ini
ln -s /etc/php/8.1/mods-available/grpc.ini /etc/php/8.1/cli/conf.d/20-grpc.ini
```
